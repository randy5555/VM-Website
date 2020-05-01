{nocache}
<section class="services5 cid-qTkA127IK8 mbr-fullscreen mbr-parallax-background" id="services5-i">
<div class="container container-table">
    <h2 class="mbr-section-title mbr-fonts-style align-center pb-3 display-2">
          Virtual Machine: {$vm.vm_name}</h2>
    <div class="container">
            
    </div>
    <div class="container card card-whitenb">
        <p>CPU: {$vm.vm_cpus}vCPU | RAM: {$vm.vm_ram}GB | Disk: {$vm.disk_space}GB | Current Status: {if $vm.vm_status eq 'off'}<span class='text-orange'><b>Powered Off</b></span>{elseif $vm.vm_status eq 'on'}<span class='text-green'><b>On</b></span>{elseif $vm.vm_status eq 'destroyed'}<span class='text-red'><b>Destroyed</b></span>{/if}</p>
    </div>
    
    <div class="table-wrapper">
        <div class="container align-center pb-3 display-2">
            <table>
                <tr>
                    <td><div class="navbar-buttons mbr-section-btn"><a class="btn btn-sm btn-success display-4" href="#" onclick="vm_start('{$vm.vm_id}');"><font face="MobiriseIcons"><br></font>Start<br></a></div></td>
                    <td><div class="navbar-buttons mbr-section-btn"><a class="btn btn-sm btn-primary display-4" href="#" onclick="vm_stop('{$vm.vm_id}');"><font face="MobiriseIcons"><br></font>Power off<br></a></div></td>
                    <td><div class="navbar-buttons mbr-section-btn"><a class="btn btn-sm btn-primary display-4" href="#" onclick="vm_shutdown('{$vm.vm_id}');"><font face="MobiriseIcons"><br></font>Shut down<br></a></div></td>
                    <td><div class="navbar-buttons mbr-section-btn"><a class="btn btn-sm btn-warning display-4" href="#" onclick="vm_destroy('{$vm.vm_id}');"><font face="MobiriseIcons"><br></font>Destroy<br></a></div></td>
                    <td><div class="navbar-buttons mbr-section-btn"><a class="btn btn-sm btn-info display-4" href="#" onclick="vm_console('{$vm.vm_id}');"><font face="MobiriseIcons"><br></font>Console<br></a></div></td>
                </tr>
            </table>
        </div>
                    
        <hr>
        
        <div class="container card card-whitenb" style='min-height:250px'>
            Graphs - Not implemented yet!
        </div>
    </div>
</div>
</section>
<script>
{literal}
function vm_start(vm_id) {
    $.get("/ajax/account?ajax=true&method=account_start_vm&vm_id=" + vm_id, function(data) {
		if(data == 'success') {
			location.href=location.href;
		} else {
			alert(data);
			
		}
	});
}

function vm_stop(vm_id) {
    $.get("/ajax/account?ajax=true&method=account_stop_vm&vm_id=" + vm_id, function(data) {
		if(data == 'success') {
			location.href=location.href;
		} else {
			alert(data);
			
		}
	});
}

function vm_shutdown(vm_id) {
    $.get("/ajax/account?ajax=true&method=account_shutdown_vm&vm_id=" + vm_id, function(data) {
		if(data == 'success') {
			location.href=location.href;
		} else {
			alert(data);
			
		}
	});
}

function vm_destroy(vm_id) {
    $.get("/ajax/account?ajax=true&method=account_destroy_vm&vm_id=" + vm_id, function(data) {
		if(data == 'success') {
			location.href=location.href;
		} else {
			alert(data);
			
		}
	});
}

function vm_console(vm_id) {
    $.get("/ajax/account?ajax=true&method=account_start_vm_console&vm_id=" + vm_id, function(data) {
		if(data == 'success') {
			location.href=location.href;
		} else {
			alert(data);
			
		}
	});
}

{/literal}
</script>
{/nocache}

