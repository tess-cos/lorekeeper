
@if(Config::get('lorekeeper.settings.show_terms_popup') == 1)
<div class="modal fade d-none" id="termsModal" role="dialog" style="display:inline;" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="padding: 25px;">
            <div class="modal-header" style="border-top: 2px dashed #e5c1c7;">
                <h5 class="modal-title" style="color: #95b582;">{{ Config::get('lorekeeper.settings.terms_popup')['title'] }}</h5>
            </div>
            <div class="modal-body">
            <p>You must be 18+ to access this site.<br />By clicking 'Accept', you are confirming to be 18 years or older and to follow the <a href="{{ url('info/terms') }}">Terms of Service</a>.</p>
            </div>
            
            <div class="modal-footer" style="border-top: 0px; border-bottom: 2px dashed #e5c1c7; margin-top: -5px;">
                <button type="button" class="btn btn-primary" id="termsButton">               
                    {{ Config::get('lorekeeper.settings.terms_popup')['button'] }}
                </button>
            </div>
        </div>
    </div>
</div>
<div class="fade modal-backdrop d-none" id="termsBackdrop"></div>


<script>
    $( document ).ready(function(){
        var termsButton = $('#termsButton');
        let termsAccepted = localStorage.getItem("terms_accepted");
        let user = "{{ Auth::user() != null }}" 
        let userAccepted = "{{ Auth::user()?->has_accepted_terms > 0 }}"

        if(user){
            if(!userAccepted){
                showPopup();
            }
        } else {
            if(!termsAccepted){
                showPopup();
            }
        }

        termsButton.on('click', function(e) {
            e.preventDefault();
            localStorage.setItem("terms_accepted", true);
            window.location.replace("/terms/accept");
        });

        function showPopup(){
            $('#termsModal').addClass("show");
            $('#termsModal').removeClass("d-none");
            $('#termsBackdrop').addClass("show");
            $('#termsBackdrop').removeClass("d-none");
        }

    });

</script>
@endif