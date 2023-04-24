const inputs = document.querySelectorAll(".form-control");

function addcl() {
    let parent = this.parentNode;
    parent.classList.add("focus");
}

function remcl() {
    let parent = this.parentNode;
    if (this.value == "") {
        parent.classList.remove("focus");
    }
}
inputs.forEach(input => {
    input.addEventListener("focus", addcl);
    input.addEventListener("blur", remcl);
});


// sidebar menu opner
$(".nav-opener").click(function () {
    $(".sidebar-menu, .navbar-profile, .main").toggleClass("active");
});

// sidebar menu opner
$("#fullscreen, .close-course-icon").click(function () {
    $(".course-book").toggleClass("fullscreen");
    $(".course-content").toggleClass("scrollbar");
    $(".speaking-course").toggleClass("d-md-flex") //======= change class name 01-10-21 ====
});

$('body').on('click', function() {
    $('.sidebar-menu').css({display:""});
});

// inline form
var size = 9;

 function resizeForText(text) {
    // alert(text)
    var text =text.replace(/\s/g, '') 
    // alert(text)
        var $this = $(this);
        var $span = $this.parent().find('span');
        $span.text(text);
        console.log(text.length);
        var $inputSize = ((text.length * size) );
      
        

        if(!flag){
            // if(text.length >6 && text.length <10){
            //         $inputSize = ((text.length * 9) );
                
            // }
        }else{
                    $inputSize = ((text.length * 9) );

        }
        if(text.length ==0){
            $inputSize = 20;
        }
        // if(text.length >50 && text.length <100){
        //         $inputSize = ((text.length * 6) );
            
        // }
    // alert(flag)
        $this.css("width", $inputSize);
        $this.css("max-width","800px");
        if(flag){
            $this.css("min-width","4px");

        }else{
            $this.css("min-width","30px");
        }

        // $this.css("color","red");
        // $this.css("font-weight","600");
        $this.css("text-align","left");
        $this.css("padding-left","0!important");
        $this.css("padding-right","0!important");
    }

$(document).ready(function () {
    var $inputs = $('.resizing-input');

    // Resize based on text if text.length > 0
    // Otherwise resize based on the placeholder

    $inputs.find('input').keypress(function (e) {
        if (e.which && e.charCode) {
            // size = 5;
            var c = String.fromCharCode(e.keyCode | e.charCode);
            var $this = $(this);
            resizeForText.call($this, $this.val() + c);
           
        }
    });

    // Backspace event only fires for keyup
    $inputs.find('input').keyup(function (e) {
// size = 7;
        // if (e.keyCode === 8 || e.keyCode === 46) {
            resizeForText.call($(this), $(this).val());
        // }
    });
    $inputs.find('input').keydown(function (e) {
        // size = 7;
        // if (e.keyCode === 8 || e.keyCode === 46) {
            resizeForText.call($(this), $(this).val());
        // }
    });

    $inputs.find('input').each(function () {
        var $this = $(this);
        resizeForText.call($this, $this.val())
    });
});

// textarea auto height

// Dealing with Textarea Height
function calcHeight(value) {
    let numberOfLineBreaks = (value.match(/\n/g) || []).length;
    // min-height + lines x line-height + padding + border
    let newHeight = 20 + numberOfLineBreaks * 20 + 12 + 2;
    return newHeight;
}

if($(".resize-ta").length > 0){
let textarea = document.querySelector(".resize-ta");
textarea.addEventListener("keyup",function(){
    textarea.style.height = calcHeight(textarea.value) + "px";
});
}


// draggabl
