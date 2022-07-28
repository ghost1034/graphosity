document.addEventListener("DOMContentLoaded", function () {
    updateInterface(document.getElementById("quadratic"));
    updateResult();

    const buttons = document.getElementsByClassName("keypad-button");
    for (let element of buttons) {
        element.addEventListener("click", function () {
            updateInput(this);
        });
    }

    const navItems = document.getElementsByClassName("nav-item");
    for (let element of navItems) {
        let link = element.firstChild;
        link.addEventListener("click", function () {
            updateInterface(this);
        });
    }

    document.getElementById("keypad-form").addEventListener("submit", function(e) {
        e.preventDefault();
        $.ajax({
            url: "equation",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify({
                "keypad-input": $('input[name="keypad-input"]').val(),
                "equation-type": $('input[name="equation-type"]').val()
            }),
            contentType: "application/json",
            success: function(data) {
                try {
                    localStorage.setItem('equation', data);
                    updateResult();
                } catch (e) {
                    console.log(e);
                }
            }
        });
    });
});

function updateResult() {
    try {
        const equation = JSON.parse(localStorage.getItem('equation'));
        const result = document.getElementById('result');
        result.value = '';
        for (let a in equation['vars']) {
            result.value += `${a} = ${equation['vars'][a]} \n`;
        }
        for (let x of equation['xInts']) {
            result.value += `x = ${x.value} \n`;
        }
        for (let y of equation['yInts']) {
            result.value += `y = ${y.value} \n`;
        }
        const event = new Event('updateresult');
        document.getElementById('graph').dispatchEvent(event);
    } catch (e) {
        console.log(e);
    }
}

function updateInterface(element) {
    const symbols = document.getElementById("symbols");
    const navItems = document.getElementsByClassName("nav-item");
    for (let i = 0; i < navItems.length; i++) {
        navItems[i].firstChild.style = "";
    }

    element.style.backgroundColor = "whitesmoke";
    element.style.color = "black";
    symbols.innerHTML = "";
    const text = ["+", "-", "x"];
    let placeholder = "";

    switch (element.id) {
        case "quadratic":
            text.push("x^2");
            placeholder = "y=ax^2+bx+c";
            break;
        case "linear":
            placeholder = "y=mx+b";
            break;
        case "exponential":
            text.push("*");
            text.push("^x");
            placeholder = "y=a*b^x";
            break;
        case "square-root":
            text.push("√()");
            placeholder = "y=√(x)";
            break;
        case "absolute-value":
            text.push("||");
            placeholder = "y=|x|";
            break;
    }
    text.push("=");

    for (let i = 0; i < text.length; i++) {
        let tr = document.createElement("tr");
        let td = document.createElement("td");
        let button = document.createElement("button");
        button.textContent = text[i];
        button.type = "button";
        button.addEventListener("click", function () {
            updateInput(this);
        });
        td.appendChild(button);
        tr.appendChild(td);
        symbols.appendChild(tr);
    }

    document.getElementById("keypad-input").value = "";
    document.getElementById("keypad-input").placeholder = placeholder;
    updateEquationType(element.id);
}

function updateInput(element) {
    if (element.innerHTML === "C") {
        document.getElementById("keypad-input").value = "";
    } else {
        document.getElementById("keypad-input").value += element.textContent;
    }
}

function updateEquationType(equationType) {
    document.getElementById("equation-type").value = equationType;
}
