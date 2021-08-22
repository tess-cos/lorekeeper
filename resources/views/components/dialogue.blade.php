@guest 
<div class="alert alert-warning">You must be logged in to view dialogue.</div>
@endguest

@auth
<div id="box" class="hide row no-gutters mb-2">
    <div class="col-2">
        <div id="image"></div>
    </div>
    <div class="col-10">
        <h3 class="card-header" id="name"></h3>
        <div class="dialogue" id="dialogue"></div>
        <div class="dialogue-responses">
            <div class="row" id="responses"></div>
        </div>
    </div>
</div>

<div class="btn btn-primary dialogue-button">Begin</div>

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
                var newData = JSON.parse(data);
                if(newData['image']) $("#image").html(newData['image']);
                if(newData['name']) $("#name").html(newData['name']);

                typeWrite(newData['text'], newData);
            }).fail(function (jqXHR, textStatus, errorThrown) { 
                alert("AJAX call failed: " + textStatus + ", " + errorThrown); 
            });
        });
    });

    function typeWrite(text, data) {
        // (A) SET DEFAULT OPTIONS
        target = document.getElementById('dialogue');
        speed = 30;
        loop = false;
        
        // (B) DRAW TYPEWRITER
        let pointer = 0;
        let timer = setInterval(function() {
        pointer++;
        if (pointer <= text.length) {
            target.innerHTML = text.substring(0, pointer);
        } else {
                if (loop) { pointer = 0; }
                else { 
                    clearInterval(timer);
                    if(data['responses']  && data['responses'].length > 0) {
                        var responses = data['responses'];
                        if(responses.length > 1) {
                            for(var i = 0; i < responses.length; i++) {
                                var response = responses[i];
                                $("#responses").append("<div class='btn btn-primary mr-1' onClick='response("+ response['id'] +")'>" + response['dialogue'] + "</div>").hide().fadeIn(200);
                            }
                        }
                        else {
                            for(var i = 0; i < responses.length; i++) {
                                var response = responses[i];
                                $("#responses").append("<div class='btn btn-primary mr-1' onClick='response("+ response['id'] +")'><i class='fas fa-caret-down'></i></div>").hide().fadeIn(200);
                            }
                        }
                    }
                    else {
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
            if(newData['image']) $("#image").html(newData['image']);
            if(newData['name']) $("#name").html(newData['name']);

            typeWrite(newData['text'], newData);
            if(!newData['responses'] || newData['responses'].length <= 0) {
                $('.dialogue-button').removeClass('hide').fadeIn(200);
            }
        }).fail(function (jqXHR, textStatus, errorThrown) { 
            alert("AJAX call failed: " + textStatus + ", " + errorThrown); 
        });
    }
</script>
@endauth