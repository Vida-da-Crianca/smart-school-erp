<div class="content-wrapper">



   <section class="content">
      <div class="box box-primary">
         <div class="box-header" style="width: 100%;  display: flex; justify-content: space-between;" >
         <div style="flex: 1;" >  <h3 class="box-title titlefix text-left" > <?php echo $this->lang->line('document_generate_collection_list'); ?> </h3></div>
         <div class="loader-i text-right"></div>   
        
            <!-- /.box-tools -->
         </div><!-- /.box-header -->
         <div class="box-body">
            <div class="table-responsive mailbox-messages">
               <div class="download_label">
                  <?php echo $this->lang->line('document_generate_collection_list'); ?> 
             
            </div>
               <table class="table table-hover table-striped table-bordered">
                  <thead>
                     <tr>
                        <th><?php echo $this->lang->line('document_title'); ?></th>

                        </th>
                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($documents as $item) : ?>
                        <tr>
                           <td><?= $item->title ?></td>
                           <td class="text-right border  t-actions" style="width: 100px; text-align: right;">

                              <!-- <a href="#" data-id="<?= $item->id ?>" on-trigger-click="preview">
                                 <i class="fa fa-file"></i>
                              </a>
                              &nbsp; -->
                              <a href="<?=site_url(sprintf('admin/documents/%s', $item->id) )?>">
                                 <i class="fa fa-edit"></i>
                              </a>
                              &nbsp;
                              <a href="#" data-id="<?= $item->id ?>" on-trigger-click="delete">
                                 <i class="fa fa-trash"></i>
                              </a>
                           </td>
                        </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </section>



</div>


<style>
   .t-actions a {
      display: inline-block;
      color: #334;
      size: 1.2rem;
   }
</style>


<script>
   $(document).ready(function() {
      var isAjax = false

      $('[on-trigger-click]').on('click.TriggerClick', function(e) {
         e.preventDefault();
         if(isAjax) return;

         var type = $(this).attr('on-trigger-click'),
            id = $(this).data('id')

       switch(type){
          case 'delete':{
            onDelete(id);
          } 
       }
      });


     
      function onDelete(id) {
         
         if (!confirm('Deseja realizar essa operação ?')) return;
         isAjax = true
         $('.loader-i').html('<i class="fa fa-circle-o-notch fa-spin"></i> Processando...')
         $.ajax({
            url: `<?= site_url('/admin/documents/') ?>${id}`,
            method: 'delete',
            dataType: 'json',
            success: function(e) {
               window.location.reload();
            },
            complete:function(){
               $('.loader-i').html('')
               isAjax = false
            }
         })
      }
     

      function onPDF(id) {
       

         $.ajax({
            url: `<?= site_url('/admin/documents/preview/') ?>${id}`,
            method: 'get',
           
            success: function(e) {
              
            }
         })
      }
      
   })
</script>