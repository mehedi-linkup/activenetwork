<div class="container">
	<div class="row">
		<div class="well" style="min-height: 500px">
			<div class="row">
            <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>
                <table class="table table-bordered"> 
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Nid</th>
                            <th>Father Name</th>
                            <th>House Name</th>
                            <th>Holding No</th>
                            <th>House No</th>
                            <th>Connection Date</th>
                            <th>Fee</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($customers as $key=>$customer):?>
                        <tr>
                            <td><?= $key+1 ?></td>
                            <td><?= $customer->name ?></td>
                            <td><?= $customer->phone ?></td>
                            <td><?= $customer->nid ?></td>
                            <td><?= $customer->father_name ?></td>
                            <td><?= $customer->house_name ?></td>
                            <td><?= $customer->holding_no ?></td>
                            <td><?= $customer->house_no ?></td>
                            <td><?= $customer->connection_date ?></td>
                            <td><?= $customer->connection_fee ?></td>
                            <td class="text-center">
                                <a href="<?php echo base_url('print_registration_form/'.$customer->id)?>" target="_blank" id="edit-area" data-id="15" class=""><i class="fa fa-print text-success" aria-hidden="true"></i></a>
                                <a href="<?php echo base_url('edit_registration/'.$customer->id)?>" target="_blank" id="edit-area" data-id="15" class=""><i class="fa fa-pencil-square-o text-success" aria-hidden="true"></i></a>
                                <a href="<?php echo base_url('delete_registration/'.$customer->id)?>" class="" id="delete-area" data-id="15"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <p><?php echo $links; ?></p>
            </div>
		</div>
	</div>
</div>
<style type="text/css" media="print">
 #order-print{
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#order-print td, #order-print th {
  border: 1px solid #ddd;
  padding: 8px;
}
hr.bg{
   border-top: 1px solid #ddd;
}
</style>
