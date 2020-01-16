function stepOne() {
    document.getElementById("step-1").style.animation = "fadeOut 1s 1";
    var y = setTimeout(step2, 900);
}

function step2() {
    document.getElementById("step-2").style.animation = "fadeIn 1s 1";
    document.getElementById('step-1').style.display = "none";
    document.getElementById('step-3').style.display = "none";
    document.getElementById('step-2').style.display = "block";

    document.getElementById('step-menu-1').style.color = "#4c148c";
    document.getElementById('step-menu-2').style.color = "#fff";
    document.getElementById('step-menu-3').style.color = "#4c148c";
}

function backtostep1() {
    document.getElementById("step-2").style.animation = "fadeOut 1s 1";
    var y = setTimeout(step1, 900);
}

function step1() {
    document.getElementById("step-1").style.animation = "fadeIn 1s 1";
    document.getElementById('step-2').style.display = "none";
    document.getElementById('step-1').style.display = "block";

    document.getElementById('step-menu-2').style.color = "#4c148c";
    document.getElementById('step-menu-1').style.color = "#fff";
}

function gotostep3() {
    document.getElementById("step-2").style.animation = "fadeOut 1s 1";
    var y = setTimeout(step3, 900);
}

function step3() {
    document.getElementById("step-3").style.animation = "fadeIn 1s 1";
    document.getElementById('step-2').style.display = "none";
    document.getElementById('step-3').style.display = "block";

    document.getElementById('step-menu-2').style.color = "#4c148c";
    document.getElementById('step-menu-3').style.color = "#fff";
}

function backtostep2() {
    document.getElementById("step-3").style.animation = "fadeOut 1s 1";
    var y = setTimeout(step2, 900);
}

function showInput(select) {
    if (select.value == 1) {
        document.getElementById('socio').style.display = "none";
        document.getElementById('empresa').style.display = "block";
    } else if (select.value == 2) {
        document.getElementById('empresa').style.display = "none";
        document.getElementById('socio').style.display = "block";
    } else {
        document.getElementById('empresa').style.display = "none";
        document.getElementById('socio').style.display = "none";
    }
}