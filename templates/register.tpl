{nocache}
<section class="services5 cid-qTkA127IK8 mbr-fullscreen mbr-parallax-background" id="services5-i">
    <!---->
    
    <!---->
    <!--Overlay-->
    <div class="mbr-overlay" style="opacity: 0.5; background-color: rgb(206, 191, 175);">
    </div>
    <!--Container-->
    <div class="container">
        <div class="row">
            <!--Titles-->
            <div class="title pb-5 col-12">
                <h2 class="align-left mbr-fonts-style m-0 display-1">Register Account</h2>
                
            </div>
             {if isset($register_message) && $register_message neq ""}
			<div class="col-md-12">
				<div class="col-md-12">
					<div class="alert alert-warning">
						 {$register_message}
					</div>
				</div>
			</div>
            {/if}
            <form action="/register" method="post" class='form form-horizontal col-lg-12' style='margin-bottom: 0;' id="regform">
                <input type="hidden" name="account_register" value="true">
                <input type="hidden" name="csrf" value="{$csrf_token}">
            <!--Card-1-->
            <div class="card card-white px-3 col-12">
                <div class="card-wrapper media-container-row media-container-row">
                    <div class="card-box">
                        <div class="top-line pb-3">
                            <h4 class="card-title mbr-fonts-style display-5">Username:</h4>
                            <div class="input-group input-group-sm mb-3 col-sm-6 col-md-6 col-lg-4">
						<input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="reg_username" name="reg_username" {if isset($reg_username)}value="{$reg_username}"{/if}>
				</div>
                        </div>
                        <div class="bottom-line">
                            
                        </div>
                    </div>
                </div>
            </div>
            <!--Card-2-->
            <div class="card card-white px-3 col-12">
                <div class="card-wrapper media-container-row media-container-row">
                    <div class="card-box">
                        <div class="top-line pb-3">
                            <h4 class="card-title mbr-fonts-style display-5">Email Address:</h4>
                            <div class="input-group input-group-sm mb-3 col-sm-6 col-md-6 col-lg-4">
						<input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="reg_email1" name="reg_email1"  {if isset($reg_email1)}value="{$reg_email1}"{/if}>
				</div>
                        </div>
                        <div class="bottom-line">
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-white px-3 col-12">
                <div class="card-wrapper media-container-row media-container-row">
                    <div class="card-box">
                        <div class="top-line pb-3">
                            <h4 class="card-title mbr-fonts-style display-5">Confirm Email Address:</h4>
                            <div class="input-group input-group-sm mb-3 col-sm-6 col-md-6 col-lg-4">
						<input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="reg_email2" name="reg_email2">
				</div>
                        </div>
                        <div class="bottom-line">
                            
                        </div>
                    </div>
                </div>
            </div>
            <!--Card-3-->
            <div class="card card-white px-3 col-12">
                <div class="card-wrapper media-container-row media-container-row">
                    <div class="card-box">
                        <div class="top-line pb-3">
                            <h4 class="card-title mbr-fonts-style display-5">Password:</h4>
                            <div class="input-group input-group-sm mb-3 col-sm-6 col-md-6 col-lg-4">
						<input type="password" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="reg_password1" name="reg_password1" >
				</div>
                        </div>
                        <div class="bottom-line">
                            
                        </div>
                    </div>
                </div>
            </div>
            <!--Card-4-->
            <div class="card card-white px-3 col-12">
                <div class="card-wrapper media-container-row media-container-row">
                    <div class="card-box">
                        <div class="top-line pb-3">
                            <h4 class="card-title mbr-fonts-style display-5">Confirm Password:</h4>
                            <div class="input-group input-group-sm mb-3 col-sm-6 col-md-6 col-lg-4">
						<input type="password" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="reg_password2" name="reg_password2">
				</div>

                        </div>
                        <div class="bottom-line">
                            
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <!--Card-5-->
            
            <!--Card-6-->
            
            <!--Card-7-->
            
            <!--Card-8-->
            
            <!--Card-9-->
            
            <!--Card-10-->
            
            <!--Card-11-->
            
            <!--Card-12-->
            
        </div>
    </div>
</section>

<section class="header1 cid-rVOsfXb6Ea" id="header16-j">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-10 align-center">
                
                
                
                <div class="mbr-section-btn"><a class="btn btn-md btn-black-outline display-4" onClick="registerSubmit();">SUBMIT</a></div>
            </div>
        </div>
    </div>
</section>
    
<script>
{literal}
function registerSubmit(token) {
	document.getElementById("regform").submit();
}
{/literal}
</script>
{/nocache}

