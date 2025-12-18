<?php include_once('controllers/bsController.php');?>
<?php $barang_list = $model->barang_array();

 ?>

<script>
  function addInput() {
    var container = document.getElementById("input-container");
    var newInput = document.createElement("div");

    var select = document.createElement("select");
    select.name = "barang[]";
    select.required = true;
	 select.classList.add("styled-input"); // Menambahkan class "styled-input" ke elemen input
    var option = document.createElement("option");
    option.value = "";
    select.appendChild(option);

    <?php foreach ($barang_list as $$key=>$barang) { ?>
      var option = document.createElement("option");
      option.value = "<?= $$key ?>";
      option.text = "<?= $barang ?>";
      select.appendChild(option);
    <?php } ?>

    var qty = document.createElement("input");
    qty.type = "text";
    qty.name = "qty[]";
    qty.placeholder = "Qty";
    qty.required = true;
	qty.classList.add("styled-input"); 
	qty.addEventListener('input', function () {
    validateInput(this);
});
	

    var lokasi = document.createElement("input");
    lokasi.type = "text";
    lokasi.name = "lokasi[]";
    lokasi.placeholder = "Lokasi";
    lokasi.required = true;
	 lokasi.classList.add("styled-input"); // Menambahkan class "styled-input" ke elemen input


    newInput.appendChild(select);
    newInput.appendChild(qty);
    newInput.appendChild(lokasi);

    container.appendChild(newInput);
  }

  function removeInput() {
    var container = document.getElementById("input-container");
    var inputs = container.getElementsByTagName("div");
    if (inputs.length > 0) {
      container.removeChild(inputs[inputs.length - 1]);
    }
  }
  
  function validateInput(input) {
    var inputValue = input.value.trim();
    var pattern = /^[1-9]\d*(\.\d+)?$/;

    if (pattern.test(inputValue)) {
        input.setCustomValidity('');
    } else {
        input.setCustomValidity('Masukkan angka atau desimal lebih dari 0 menggunakan titik (.)');
    }
}
</script>

 <style>
    .styled-input {
      padding: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 14px;
      margin-bottom: 10px;
	  margin-right:10px
    }
  </style>
<div class="row">
<div class="col-xs-12">
<div class="box">
<div class="box-header"></div>
<div class="box-body">


<form action="" method="post">
  <div id="input-container">
   
    <?php

	if ($_POST['input_preview']) {
		$row = $_POST['preview_jumlah_row'];
		 $explode = explode("#",$_POST['preview_barang_bs']);
			
		 $barang_selected['barang_bs_id'] = $explode[0];
		 $barang_selected['barang_nama'] = $explode[1];
		 $lokasi_selected = $_POST['preview_lokasi_bs'];
	} else {
		$row = 1;
		 $barang_selected = [];
		 $lokasi_selected = null ; 
	}
	
   
	for ($x=1; $x <= $row; $x++) { ?>
	<select name="barang[]" required class="styled-input" style="margin-right:7px">
	<option value="<?=$barang_selected['barang_bs_id']?>"><?=$barang_selected['barang_nama']?></option>
	<?php foreach ($barang_list as $key=>$barang) { 
	if ($key != $barang_selected['barang_bs_id']) {
	?>
	<option value="<?= $key ?>"><?= $barang ?></option>
	<?php } }?>
	</select>
	<input style="width:50px" class="styled-input" type="text" name="qty[]" placeholder="Qty" required pattern="^[1-9]\d*(\.\d+)?$" title="Enter a valid number or decimal greater than zero using dot (.)"  style="margin-right:7px">
	
	<select name="lokasi[]" required class="styled-input" >
	<option value="<?=$lokasi_selected?>"><?=$lokasi_selected?></option>
	<?php foreach ($model->lokasi_list() as $lokasi) { 
	if ($lokasi != $lokasi_selected ) {
	?>
	<option value="<?= $lokasi ?>"><?= $lokasi ?></option>
	<?php } }?>
	</select>
	
	
	<input class="styled-input" type="text" name="project[]" placeholder="Jenis Kain"  >
	<input class="styled-input" type="text" name="demand[]" placeholder="Keterangan"  >
	<input style="width:100px" class="styled-input" type="text" name="mc[]" placeholder="MC"  >
	<input style="width:50px" class="styled-input" type="text" name="lbr[]" placeholder="Lbr"  >
	<input style="width:50px" class="styled-input" type="text" name="grm[]" placeholder="Grm"  >
	
	<?php } ?>
  
  
    
  </div>

 <!--
  <a onclick="addInput()">Add</a>
  |
  <a onclick="removeInput()">Remove</a>
-->
  <br>


</div>
</div>
</div>
</div>

  <input type="submit" value="Save" name="Save" class="btn btn-success ">
</form>


<script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get all elements with the specified class
            var numericInputs = document.querySelectorAll('.numeric-input');

            // Function to validate the input
            function validateInput(input) {
                // Get the input value
                var inputValue = input.value.trim();

                // Get the maximum value from the data-max attribute
                var max = parseFloat(input.dataset.max);

                // Validate if the input is a number or a decimal
                if (/^\d*\.?\d*$/.test(inputValue)) {
                    // Check if the value is greater than 0 and less than or equal to the maximum
                    var numericValue = parseFloat(inputValue);
                    if (numericValue > 0 && numericValue <= max) {
                        // Replace commas with dots for decimals
                        inputValue = inputValue.replace(',', '.');

                        // Update the input value
                        input.value = inputValue;
                    } else {
                        // If the value is not within the allowed range, reset the input value
                        input.value = '';
                        alert('Please enter a number between 0 and ' + max + '.');
                    }
                } else {
                    // If the input is not a number or decimal, reset the input value
                    input.value = '';
                    alert('Please enter a valid number or decimal using dot (.)');
                }
            }

            // Attach an event listener to each input field
            numericInputs.forEach(function (input) {
                var timeout;

                input.addEventListener('input', function () {
                    // Clear previous timeout
                    clearTimeout(timeout);

                    // Set a new timeout
                    timeout = setTimeout(function () {
                        // Validate the input after the delay
                        validateInput(input);
                    }, 2000);
                });
            });
        });
</script>


