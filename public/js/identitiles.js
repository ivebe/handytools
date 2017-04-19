/**
 * Identitiles.
 *
 * @author Danijel Petrovic, Ivebe
 */
function identitiles(canvasID, md5str) {
    var cv = document.getElementById(canvasID);
    var ct = cv.getContext('2d');

    var borderColor = 'FFF';

    var w = cv.width;
    var h = cv.height;

    var boxW = w / 3;
    var boxH = h / 3;

    var str = md5str + 'f';

    ct.clearRect(0, 0, w, h);

    var x=0;
    var y=0;
    var currColor;
    var p1=0;
    var p2=0;

    for(var i=0; i<9; i++)
    {
        if(i == 0) {
            p1=0;
            p2=6;
        }
        else {
            p1 = i*3+3;
            p2 = p1+3;
        }

        if(i == 8) {
            p2+=3;
        }

        currColor = str.substring(p1, p2);

        ct.fillStyle = '#' + borderColor;
        ct.fillRect(x, y, boxW, boxH);

        ct.fillStyle = '#' + currColor;
        ct.fillRect(x+1, y+1, boxW-2, boxH-2);

        if((i+1)%3!=0)
            x += boxW;
        else{
            x = 0;
            y += boxH;
        }
    }
}