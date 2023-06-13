		<?php
// to get today's date
        date_default_timezone_set('Asia/Kolkata');
        $date = date("d-m-Y H:i:s");

        // filename to save the filename according to the need
        @header("Content-Disposition: attachment; filename=products(".$date.").csv");

        // for column names (comma is used for different cells in a row)



        $data = "S. NO. , Code,  HSN/SAC Code, Name, Category, Cost, Price, Unit, Quantity, Weight"."\n";

        $i = 0;
        foreach($products as $value)
        {
          $i++;
          $data .= $i.",";
          $data .= str_replace("," , "", $value->code ).",";
          $data .= str_replace("," , "", $value->hsn_sac_code ).",";
          $data .= str_replace("," , "", $value->name ).",";
          $data .= str_replace("," , "", $value->category_name ).",";
          $data .= str_replace("," , "", $value->cost ).",";
          $data .= str_replace("," , "", $value->price ).",";
          $data .= str_replace("," , "", $value->unit ).",";
          $data .= str_replace("," , "", $value->quantity );
          $data .= str_replace("," , "", $value->weight )."\n";

	
        }


        // to print the data in the excel
        echo $data;

        // because we just need to download the excel file, so need to open this file
        exit();
?>