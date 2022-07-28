document.addEventListener("DOMContentLoaded", function() {
    let scale = 20;
    let moving = false;
    let startMouseX;
    let startMouseY;
    let canvas = document.getElementById("graph");
    let ctx = canvas.getContext("2d");
    let width = canvas.width;
    let height = canvas.height;
    let xOffset = (height / 2) % scale;
    let yOffset = (width / 2) % scale;
    let equation;
    resize();

    canvas.addEventListener("updateresult", function() {
        equation = JSON.parse(localStorage.getItem('equation'));
        draw();
    });

    function draw() {
        let heightCenter = height / 2 - height / 2 % scale + xOffset;
        let widthCenter = width / 2 - width / 2 % scale + yOffset;
        ctx.clearRect(0, 0, width, height);
        ctx.beginPath();
        ctx.lineWidth = 1;
        ctx.strokeStyle = "lightgray";
        ctx.font = "10px Arial";

        for (let i = xOffset % scale; i < height + scale; i += scale) {
            ctx.moveTo(0, i);
            ctx.fillText((Math.round(height / scale / 2 - i / scale + (xOffset - height / 2 % scale) / scale)).toString(), widthCenter, i);
            ctx.lineTo(width, i);
        }
        for (let i = yOffset % scale - scale; i < width; i += scale) {
            ctx.moveTo(i, 0);
            ctx.fillText((Math.round(-1 * width / scale / 2 + i / scale - (yOffset - width / 2 % scale) / scale)).toString(), i, heightCenter);
            ctx.lineTo(i, height);
        }

        ctx.stroke();

        ctx.beginPath();
        ctx.lineWidth = 2;
        ctx.strokeStyle = "gray";
        ctx.moveTo(0, heightCenter);
        ctx.lineTo(width, heightCenter);
        ctx.moveTo(widthCenter, 0);
        ctx.lineTo(widthCenter, height);
        ctx.stroke();

        let x = -1 * width / scale - yOffset / scale;
        let y;

        ctx.beginPath();
        ctx.lineWidth = 2;
        ctx.strokeStyle = "red";
        y = getY(x);

        while (x < width / scale - yOffset / scale) {
            ctx.moveTo(widthCenter + x * scale, heightCenter - y * scale);
            x += 0.001;
            y = getY(x);
            ctx.lineTo(widthCenter + x * scale, heightCenter - y * scale);
        }

        ctx.stroke();
    }

    function getY(x) {
        if (equation) {
            switch (equation['type']) {
                case "quadratic":
                    return equation['vars']['a'] * x ** 2 + equation['vars']['b'] * x + equation['vars']['c'];
                    break;
                case "linear":
                    return equation['vars']['m'] * x + equation['vars']['b'];
                    break;
                case "exponential":
                    return equation['vars']['a'] * Math.abs(equation['vars']['b']) ** x + equation['vars']['c'];
                    break;
                case "square-root":
                    return equation['vars']['a'] * Math.sqrt(x - equation['vars']['h']) + equation['vars']['k'];
                    break;
                case "absolute-value":
                    return equation['vars']['a'] * Math.abs(x - equation['vars']['h']) + equation['vars']['k'];
                    break;
                default:
                    return Math.sqrt(-1);
            }
        }
    }

    function resize() {
        canvas.width = document.getElementById("graph-area").clientWidth;
        canvas.height = document.getElementById("graph-area").clientHeight;
        width = canvas.width;
        height = canvas.height;
        draw();
    }

    window.addEventListener("resize", function() {
        resize();
    });

    canvas.addEventListener("mousedown", function(e) {
        moving = true;
        startMouseX = e.clientX;
        startMouseY = e.clientY;
    });

    canvas.addEventListener("mousemove", function(e) {
        if (moving) {
            let xDirection = (e.clientX - startMouseX);
            let yDirection = (e.clientY - startMouseY);
            yOffset += xDirection;
            xOffset += yDirection;
            draw();
            startMouseX = e.clientX;
            startMouseY = e.clientY;
        }
    });

    canvas.addEventListener("mouseup", function(e) {
        moving = false;
        startMouseX = 0;
        startMouseY = 0;
    });

    canvas.addEventListener("mouseout", function(e) {
        moving = false;
        startMouseX = 0;
        startMouseY = 0;
    });
});
