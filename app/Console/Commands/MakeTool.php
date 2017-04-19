<?php

namespace App\Console\Commands;

use App\IParser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class MakeTool extends Command
{
    /**
     * @var string
     */
    private $classTemplate = <<<'PHP'
<?php

namespace App\Tools;

use App\Tools\Contracts\ITool;
use App\Annotations\ToolsAnnotation;
use Illuminate\Http\Request;

use Illuminate\Foundation\Inspiring;


class {NAME} implements ITool
{
    /**
     * @ToolsAnnotation(
     *     name="{name}",
     *     serve=true,
     *     description="This is just a demo tool placeholder"
     * )
     */
    public function get(Request $request)
    {
        // TODO: If you need some data on tool initialisation use this function
    }

    public function post(Request $request)
    {
        return response()->json([
            'text' => Inspiring::quote()
        ]);
    }
}
PHP;

    /**
     * @var string
     */
    private $vueTemplate = <<<'VUE'
<template>
    <form>
        <div class="form-group">
            <input v-model="text" type="text" class="form-control">
        </div>
    </form>
</template>

<script>


export default {
    data(){
        return {
            text: ''
        }
    },

    mounted(){
        this.getText()
    },

    methods: {
        getText:
            function () {

                var vm = this

                vm.text = 'Processing...';

                axios.get('/api/{name}/get',{
                })
                .then(function (response) {
                    vm.text  = response.data.text
                })
                .catch(function (error) {
                    vm.text = 'Error! Could not reach the API. ' + error
                })
            }
    }
}
</script>
VUE;



    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:tool {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates new tool in the both API and Vue assets';

    /**
     * @var IParser
     */
    private $parser;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(IParser $parser)
    {
        parent::__construct();

        $this->parser = $parser;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tools = $this->parser->getTools();

        foreach ($tools as $tool)
            if (isset($tool['name']) && strtolower($tool['name']) == strtolower($this->argument('name'))){
                $this->error('ERROR:');
                $this->line('This tool already exist, choose another name');
                return;
            }

        //Laravel
        $php = str_replace('{NAME}', ucfirst($this->argument('name')), $this->classTemplate);
        $php = str_replace('{name}', strtolower($this->argument('name')), $php);

        $filePath = app_path('Tools/' . ucfirst($this->argument('name')));

        file_put_contents($filePath . '.php', $php);

        //Vue
        $vue = str_replace('{name}', strtolower($this->argument('name')), $this->vueTemplate);
        $filePath = base_path('resources/assets/js/tools/' . strtolower($this->argument('name')) . '.vue');
        file_put_contents($filePath, $vue);

        Cache::forget('parser_tools_list');

        $this->info('Done. Don`t forget to add route to Vue route.js file.');
    }
}
