<div id="box" class="hide mb-2">
    <div class="row no-gutters">
        <div id='image-container' class="col-2">
            <div id="image"></div>
        </div>
        <div id='main-dialogue' class="col-10">
            <h3 class="card-header col-12" id="name"></h3>
            <div class="dialogue" id="dialogue"></div>
        </div>
    </div>
    <div class="col-12 mt-3">
        <div class="float-right dialogue-responses">
            <div class='btn btn-warning mr-1 stop' onclick="stopTypeWrite()"><i class="fas fa-angle-double-right"></i></div>
            <div class="row" id="responses"></div>
        </div>
    </div>
</div>

<div class="btn btn-primary dialogue-button mx-2 mb-1">Begin Dialogue</div>

{{-- SCRIPTS AREA --}}
<script>
    $( document ).ready(function() {  
        $('.dialogue-button').on("click", function(e) {
            $("#box").removeClass('hide');
            var id = "<?php echo($id) ?>";
            $("#responses").html("");
            $('.dialogue-button').addClass('hide');

            $.ajax({
                    type: "GET", url: "{{ url('dialogue/get-text') }}?id="+id, dataType: "text"
                }).done(function (data) { 
                    //console.log(data);
                var newData = JSON.parse(data);
                $("#dialogue").html('');
                if(newData['image']) {
                    $('#image-container').addClass('col-2');
                    $('#main-dialogue').removeClass('col-12');
                    $('#main-dialogue').addClass('col-10');

                    $("#image").html("");
                    $("#image").html(newData['image']);
                } 
                else {
                    $('#image-container').removeClass('col-2');
                    $('#main-dialogue').removeClass('col-10');
                    $('#main-dialogue').addClass('col-12');

                    $("#image").html("");
                }
                if(newData['name'] && newData['name'] != ' ') $("#name").html(newData['name']);
                else if(newData['name'] && newData['name'] == ' ') $("#name").html("");
                else $("#name").html("");

                typeWrite(newData['text'], newData);
            }).fail(function (jqXHR, textStatus, errorThrown) { 
                alert("AJAX call failed: " + textStatus + ", " + errorThrown); 
            });
        });
    });

    // INITIALIASATION //
    //                 //
    //                 //
    //                 //
    @if(Auth::check())
        let speed = "<?php echo Auth::user()->settings->text_speed; ?>";
    @else
        let speed = 30;
    @endif
    let pointer = 0;
    let target = document.getElementById('dialogue');
    let globalText = "";

    function stopTypeWrite() {
        // make sure the text is fully visible
        $('.stop').addClass('hide');
        pointer = globalText.length;
        target.innerHTML = globalText;
    }

    function typeWrite(text, data) {
        // (A) SET DEFAULT OPTIONS
        $('.stop').removeClass('hide');
        loop = false;
        globalText = text
        // (B) DRAW TYPEWRITER
        pointer = 0;
        let timer = setInterval(function() {
        pointer++;
            if (pointer <= text.length) {
                target.innerHTML = text.substring(0, pointer);
            } 
            else {
                if (loop) { pointer = 0; }
                else { 
                    clearInterval(timer);
                    if(data['responses']  && data['responses'].length > 0) {
                        var responses = data['responses'];
                        if(responses.length > 1) {
                            $('.stop').addClass('hide');
                            for(var i = 0; i < responses.length; i++) {
                                var response = responses[i];
                                $("#responses").append("<br><div class='btn btn-primary mr-1' onClick='response("+ response['id'] +")'>" + response['dialogue'] + "</div>").hide().fadeIn(200);
                            }
                        }
                        else {
                            $('.stop').addClass('hide');
                            for(var i = 0; i < responses.length; i++) {
                                var response = responses[i];
                                $("#responses").append("<br><div class='btn btn-primary mr-1' onClick='response("+ response['id'] +")'><i class='fas fa-caret-down'></i></div>").hide().fadeIn(200);
                            }
                        }
                    }
                    else {
                        $('.stop').addClass('hide');       
                        $(".dialogue-button").html("Read Again?");
                        $('.dialogue-button').removeClass('hide').fadeIn(200);
                    }
                }   
            }
        }, speed);
    }

    function response(id) {
        $("#responses").html("");
        $.ajax({
            type: "GET", url: "{{ url('dialogue/get-text') }}?id="+id, dataType: "text"
            }).done(function (data) { 
            var newData = JSON.parse(data);
            if(newData['image']) { 
                $('#image-container').addClass('col-2');
                    $('#main-dialogue').removeClass('col-12');
                    $('#main-dialogue').addClass('col-10');

                    $("#image").html("");
                    $("#image").html(newData['image']);
            } 
            else {
                $('#image-container').removeClass('col-2');
                $('#main-dialogue').removeClass('col-10');
                $('#main-dialogue').addClass('col-12');

                $("#image").html("");
            }
            if(newData['name'] && newData['name'] != ' ') $("#name").html(newData['name']);
            else if(newData['name'] && newData['name'] == ' ') $("#name").html("");
            else $("#name").html("");

            typeWrite(newData['text'], newData);
        }).fail(function (jqXHR, textStatus, errorThrown) { 
            alert("AJAX call failed: " + textStatus + ", " + errorThrown); 
        });
    }
</script>