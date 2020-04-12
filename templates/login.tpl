{nocache}
<section class="services5 cid-qTkA127IK8 mbr-fullscreen mbr-halfscreen mbr-parallax-background" id="features11-10">
    <div class="mbr-overlay" style="opacity: 0.5; background-color: rgb(255, 255, 255);">
    </div>

    <div class="container">   
        <div class="row">
        <div class="col-md-12">
            {if isset($login_message) && $login_message neq ""}
		<div class="col-md-12">
			<div class="col-md-12">
				<div class="alert alert-warning">
					 {$login_message}
				</div>
			</div>
		</div>
		{/if}
            <div class="media-container-row">
                <div class="mbr-figure m-auto" style="width: 55%;">
                    <img src="/images/mbr-analityka-big.jpg" >
                </div>
                <div class=" align-left aside-content">
                    <h2 class="mbr-title pt-2 mbr-fonts-style display-2">Login</h2>
                    <div class="mbr-section-text">
                        
                    </div>

                    <div class="block-content">
                        <form action="/" method="post" class='form form-horizontal validate-form' style='margin-bottom: 0;' id="loginform" name="loginform">
                            <input type="hidden" name="auth" value="true"/>
                        <div class="card card-nb p-3 pr-3">
                            <div class="media">
                                     
                                <div class="media-body">
                                    <h4 class="card-title mbr-fonts-style display-7"><br>Username:</h4>
                                </div>
                            </div>                

                            <div class="card-box">
					<div class="input-group input-group-sm mb-3">
						<input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="username" name="username">
					</div>
                            </div>
                        </div>

                        <div class="card card-nb p-3 pr-3">
                            <div class="media">
                                     
                                <div class="media-body">
                                    <h4 class="card-title mbr-fonts-style display-7">
                                        <br><br>Password:</h4>
                                </div>
                            </div>                

                            <div class="card-box">
                                <div class="input-group input-group-sm mb-3">
						<input type="password" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="password" name="password">
					</div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
        </div> 
    </div>          
</section>

<section class="mbr-section info1 cid-rVOzGnNiN8" id="info1-12">
    
    <div class="container">
        <div class="row justify-content-center content-row">
            <div class="media-container-column title col-12 col-lg-7 col-md-6">
                
                
            </div>
            <div class="media-container-column col-12 col-lg-3 col-md-4">
                <div class="mbr-section-btn align-right py-4"><a class="btn btn-primary display-4" onclick="loginSubmit()">SUBMIT</a></div>
            </div>
        </div>
    </div>
</section>
<script>
{literal}
function loginSubmit() {
	$( "#loginform" ).submit();
}

{/literal}
</script>
{/nocache}
