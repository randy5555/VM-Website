{nocache}
<section class="services5 cid-qTkA127IK8 cid-rVY52zhta2 mbr-fullscreen mbr-parallax-background" id="content" >
<div class="container align-center">
        <div class="container">
        <div class="row">
            <!--Titles-->
            <div class="title pb-5 col-12">
                <h2 class="align-left mbr-fonts-style m-0 display-1"><!-- Empty --></h2>
            </div>
            
            <div class="title pb-5 col-12">
                <h2 class="align-left mbr-fonts-style m-0 display-1">Create Virtual Machine</h2>
            </div>
            {if isset($error_message) && $error_message neq ""}
            <div class="col-md-12">
                    <div class="col-md-12">
                            <div class="alert alert-warning">
                                     {$error_message}
                            </div>
                    </div>
            </div>
            {/if}
            <form action="/account/create" method="post" class='form form-horizontal col-lg-12' style='margin-bottom: 0;' id="createform">
                <input type="hidden" name="create_vm" value="true">
                <input type="hidden" name="csrf" value="{$csrf_token}">
            <!--Card-1-->
            <div class="card px-3 col-12 card-whitenb">
                <div class="card-wrapper media-container-row media-container-row">
                    <div class="card-box">
                        
                         <div class="form-group row">
                            <label for="create_name" class="col-sm-2 col-form-label card-title mbr-fonts-style display-5">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="create_name" name='create_name'>
                            </div>
                        </div>
                        
                        <div class="bottom-line"></div>
                    </div>
                </div>
            </div>
            <!--Card-2-->
            <div class="card px-3 col-12 card-whitenb">
                <div class="card-wrapper media-container-row media-container-row">
                    <div class="card-box">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label card-title mbr-fonts-style display-5" for="create_ram">RAM Size</label>
                            <div class="col-sm-10">
                                <select class="custom-select my-1 mr-sm-2" id="create_ram" name='create_ram'>
                                    <option selected>Choose...</option>
                                    <option value="1">1GB</option>
                                    <option value="2">2GB</option>
                                    <option value="4">4GB</option>
                                    <option value="8">8GB</option>
                                    <option value="16">16GB</option>
                                    <option value="32">32GB</option>
                                    <option value="64">64GB</option>
                                    <option value="128">128GB</option>
                                </select>
                            </div>
                        </div>
                        <div class="bottom-line"></div>
                    </div>
                </div>
            </div>
            <!--Card-3-->
            <div class="card px-3 col-12 card-whitenb">
                <div class="card-wrapper media-container-row media-container-row">
                    <div class="card-box">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label card-title mbr-fonts-style display-5" for="create_cpu">CPUs</label>
                            <div class="col-sm-10">
                                <select class="custom-select my-1 mr-sm-2" id="create_cpu" name='create_cpu'>
                                    <option selected>Choose...</option>
                                    <option value="1">1 vCPU</option>
                                    <option value="2">2 vCPU</option>
                                    <option value="3">3 vCPU</option>
                                    <option value="4">4 vCPU</option>
                                    <option value="6">6 vCPU</option>
                                    <option value="8">8 vCPU</option>
                                    <option value="12">12 vCPU</option>
                                    <option value="16">16 vCPU</option>
                                    <option value="20">20 vCPU</option>
                                </select>
                            </div>
                        </div>
                        <div class="bottom-line"></div>
                    </div>
                </div>
            </div>
            <!--Card-4-->
            <div class="card px-3 col-12 card-whitenb">
                <div class="card-wrapper media-container-row media-container-row">
                    <div class="card-box">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label card-title mbr-fonts-style display-5" for="create_disk">Disk Space</label>
                            <div class="col-sm-10">
                                <select class="custom-select my-1 mr-sm-2" id="create_disk" name='create_disk'>
                                    <option selected>Choose...</option>
                                    <option value="18">18GB vDisk</option>
                                    <option value="25">25GB vDisk</option>
                                    <option value="30">30GB vDisk</option>
                                    <option value="40">40GB vDisk</option>
                                    <option value="55">55GB vDisk</option>
                                    <option value="75">75GB vDisk</option>
                                    <option value="100">100GB vDisk</option>
                                    <option value="250">250GB vDisk</option>
                                </select>
                            </div>
                        </div>
                        <div class="bottom-line">
                            
                        </div>
                    </div>
                </div>
            </div>
             <!--Card-4-->
            <div class="card px-3 col-12 card-whitenb">
                <div class="card-wrapper media-container-row media-container-row">
                    <div class="card-box">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label card-title mbr-fonts-style display-5" for="create_os">Operating System</label>
                            <div class="col-sm-10">
                                <select class="custom-select my-1 mr-sm-2" id="create_os" name='create_os'>
                                    <option selected>Choose...</option>
                                    <option value="1">CentOS-7-x86_64-1908</option>
                                    <option value="2">CentOS-8.1.1911-x86_64</option>
                                    <option value="3">debian-10.3.0-amd64-netinst</option>
                                    <option value="4">debian-9.12.0-amd64-netinst</option>
                                    <option value="5">Fedora-Server--x86_64-31-1.9</option>
                                    <option value="6">Fedora-Server--x86_64-32_Beta-1.2</option>
                                    <option value="7">Fedora-Silverblue-ostree-x86_64-31-1.9</option>
                                    <option value="8">Fedora-Workstation-Live-x86_64-31-1.9</option>
                                    <option value="9">Fedora-Workstation-Live-x86_64-32_Beta-1.2</option>
                                    <option value="10">FreeBSD-11.3-RELEASE-amd64-1</option>
                                    <option value="11">FreeBSD-11.3-STABLE-amd64</option>
                                    <option value="12">FreeBSD-12.1-RELEASE-amd64-1</option>
                                    <option value="13">FreeBSD-13.0-CURRENT-amd64</option>
                                    <option value="14">ubuntu-14.04.6-desktop-amd64</option>
                                    <option value="15">ubuntu-14.04.6-server-amd64</option>
                                    <option value="16">ubuntu-16.04.6-desktop-amd64</option>
                                    <option value="17">ubuntu-16.04.6-server-amd64</option>
                                    <option value="18">ubuntu-18.04.4-desktop-amd64</option>
                                    <option value="19">ubuntu-19.10-desktop-amd64</option>
                                    <option value="20">ubuntu-20.04-beta-desktop-amd64</option>
                                    <option value="21">ubuntu-20.04-beta-live-server-amd64</option>
                                </select>
                            </div>
                        </div>
                        <div class="bottom-line">
                            
                        </div>
                    </div>
                </div>
            </div>
            <!--Card-5-->
            <div class="card px-3 col-12 card-whitenb">
                <div class="card-wrapper media-container-row media-container-row">
                    <div class="card-box">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label card-title mbr-fonts-style display-5" for="create_server">Host Server</label>
                            <div class="col-sm-10">
                                <select class="custom-select my-1 mr-sm-2" id="create_server" name='create_server'>
                                    <option selected>Choose...</option>
                                    {foreach key=type item=data from=$enabled_servers}
                                        <option value="{$data.server_id}">{$data.server_name}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        <div class="bottom-line">
                            
                        </div>
                    </div>
                </div>
            </div>
            <!--Card-6-->
            
            <!--Card-7-->
            
            <!--Card-8-->
            
            <!--Card-9-->
            
            <!--Card-10-->
            
            <!--Card-11-->
            
            <!--Card-12-->
            </form>
            
        </div>
    </div>
    </div>
    

</div>
</section>
<section class="header1 cid-rVOsfXb6Ea" id="header16-j">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-10 align-center">
                <div class="mbr-section-btn"><a class="btn btn-md btn-black-outline display-4" onClick="createSubmit();">Create</a></div>
            </div>
        </div>
    </div>
</section>
<script>
{literal}
function createSubmit(token) {
	document.getElementById("createform").submit();
}
{/literal}
</script>
{/nocache}
