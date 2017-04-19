<template>

    <transition-group name="fade" tag="div">
        <a :href="/#/ + item.route" v-for="(item, i) in items" v-bind:key="item.name">
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ item.name | capitalize }}</h3>
                </div>
                <div class="panel-body">
                    {{ item.description }}
                </div>
            </div>
        </div>
        </a>
    </transition-group>

</template>

<script>

export default {
    data() {
        return {
            items: []
        }
    },

    created() {
        axios.get('/api/').then((response) => {
            this.items = response.data;
        });

        $('body').addClass('animatedbg');
    },

    destroyed() {
        $('body').removeClass('animatedbg');
    },

    methods: {
    },

    filters: {
        capitalize: function (value) {
            if (!value) return ''
            value = value.toString()
            return value.charAt(0).toUpperCase() + value.slice(1)
        }
    }

}
</script>

<style>

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
        opacity: 0
    }

    .col-md-3{
        padding:2px;
    }

    .panel{
        padding:0;
        background-color: rgba(255,255,255,0.8);
    }

    .panel:hover{
        box-shadow: 0px 0px 25px #444;
        z-index: 2;
        -webkit-transition: all 200ms ease-in;
        -webkit-transform: scale(1.02);
        -ms-transition: all 200ms ease-in;
        -ms-transform: scale(1.02);
        -moz-transition: all 200ms ease-in;
        -moz-transform: scale(1.02);
        transition: all 200ms ease-in;
        transform: scale(1.02);
    }

    a, a:hover, a:visited{
        color: black;
    }

    .animatedbg {
        background: linear-gradient(270deg, #ed3504, #d0e312, #cb5800);
        background-size: 600% 600%;

        -webkit-animation: AnimatedBG 60s ease infinite;
        -moz-animation: AnimatedBG 60s ease infinite;
        animation: AnimatedBG 60s ease infinite;
    }
    @-webkit-keyframes AnimatedBG {
        0%{background-position:0% 50%}
        50%{background-position:100% 50%}
        100%{background-position:0% 50%}
    }
    @-moz-keyframes AnimatedBG {
        0%{background-position:0% 50%}
        50%{background-position:100% 50%}
        100%{background-position:0% 50%}
    }
    @keyframes AnimatedBG {
        0%{background-position:0% 50%}
        50%{background-position:100% 50%}
        100%{background-position:0% 50%}
    }
</style>