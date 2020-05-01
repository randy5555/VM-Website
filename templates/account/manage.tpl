{nocache}
<section class="cid-qTkA127IK8 mbr-fullscreen mbr-parallax-background" id="content" style="z-index: 0;  position: relative;">
<div class="container container-table">
      <h2 class="mbr-section-title mbr-fonts-style align-center pb-3 display-2">
          List of Your Virtual Machines</h2>
      
      <div class="table-wrapper">
        <div class="container">
          
        </div>

        <div class="container">
          <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer"><div id="DataTables_Table_0_filter" class="dataTables_filter"><label class="display-7">Search:<input type="search" class="form-control input-sm" placeholder="" aria-controls="DataTables_Table_0"></label></div><div class="dataTables_scroll card-whitenb"><div class="dataTables_scrollHead" style="overflow: hidden; position: relative; border: 0px; width: 100%;"><div class="dataTables_scrollHeadInner" style="box-sizing: content-box; width: 1080px; padding-right: 0px;"><table class="table isSearch dataTable no-footer" cellspacing="0" role="grid" style="margin-left: 0px; width: 1080px;"><thead>
              <tr class="table-heads " role="row">
                  <th class="head-item mbr-fonts-style display-7 sorting_desc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 130px;" aria-label="NAME: activate to sort column ascending" aria-sort="descending">
                      NAME
                  </th>
                  <th class="head-item mbr-fonts-style display-7 sorting_desc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 130px;" aria-label="STATUS: activate to sort column ascending" aria-sort="descending">
                      Status
                  </th>
                  <th class="head-item mbr-fonts-style display-7 sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 125px;" aria-label="RAM: activate to sort column ascending">RAM</th><th class="head-item mbr-fonts-style display-7 sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 112px;" aria-label="
                      CPUs: activate to sort column ascending">
                      CPUs</th><th class="head-item mbr-fonts-style display-7 sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 194px;" aria-label="Disk Space: activate to sort column ascending">Disk Space</th><th class="head-item mbr-fonts-style display-7 sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 133px;" aria-label="
                      Server: activate to sort column ascending">
                      Server</th><th class="head-item mbr-fonts-style display-7 sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 132px;" aria-label="View: activate to sort column ascending">View</th></tr>
            </thead></table></div></div><div class="dataTables_scrollBody" style="position: relative; overflow: auto; width: 100%;"><table class="table isSearch dataTable no-footer" cellspacing="0" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info" style="width: 1078px;"><thead>
              <tr class="table-heads " role="row" style="height: 0px;"><th class="head-item mbr-fonts-style display-7 sorting_desc" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 130px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="
                      NAME: activate to sort column ascending" aria-sort="descending"><div class="dataTables_sizing" style="height:0;overflow:hidden;">
                      NAME</div></th><th class="head-item mbr-fonts-style display-7 sorting" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 125px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="RAM: activate to sort column ascending"><div class="dataTables_sizing" style="height:0;overflow:hidden;">RAM</div></th><th class="head-item mbr-fonts-style display-7 sorting" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 112px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="
                      CPUs: activate to sort column ascending"><div class="dataTables_sizing" style="height:0;overflow:hidden;">
                      CPUs</div></th><th class="head-item mbr-fonts-style display-7 sorting" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 194px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Disk Space: activate to sort column ascending"><div class="dataTables_sizing" style="height:0;overflow:hidden;">Disk Space</div></th><th class="head-item mbr-fonts-style display-7 sorting" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 133px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="
                      Server: activate to sort column ascending"><div class="dataTables_sizing" style="height:0;overflow:hidden;">
                      Server</div></th><th class="head-item mbr-fonts-style display-7 sorting" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 132px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="View: activate to sort column ascending"><div class="dataTables_sizing" style="height:0;overflow:hidden;">View</div></th></tr>
            </thead>
            

            <tbody>
                {foreach key=type item=data from=$vms}
                    <tr role="row" class="odd"> 
                <td class="body-item mbr-fonts-style display-7 sorting_1">{$data.vm_name}</td><td class="body-item mbr-fonts-style display-7 sorting_1">{if $data.vm_status eq 'off'}<span class='text-orange'><b>Powered Off</b></span>{elseif $data.vm_status eq 'on'}<span class='text-green'><b>On</b></span>{elseif $data.vm_status eq 'destroyed'}<span class='text-red'><b>Destroyed</b></span>{/if}</td><td class="body-item mbr-fonts-style display-7">{$data.vm_ram} GB</td><td class="body-item mbr-fonts-style display-7">{$data.vm_cpus} vCPU</td><td class="body-item mbr-fonts-style display-7">{$data.disk_space} GB</td><td class="body-item mbr-fonts-style display-7">{$data.server_name}</td><td class="body-item mbr-fonts-style display-7"><a href='/account/manage/{$data.vm_id}'>Manage</a></td>
                </tr>
                {/foreach}
            </tbody>
          </table></div></div><div class="dataTables_info display-7" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing 1 entries</div></div>
        </div>
        <div class="container table-info-container">
          
        </div>
      </div>
    </div>
    

</div>
</section>
{/nocache}
