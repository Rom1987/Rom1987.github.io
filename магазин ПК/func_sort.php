<?php
function user_sort($ord) {
  global $link;
  if($_REQUEST['age']=='ID') {      
    $order = "ORDER BY ID $ord";
  }    
  if($_REQUEST['age']=='L_F_S') {      
    $order = "ORDER BY L_F_S $ord";
  }   
  if($_REQUEST['age']=='Address') {      
    $order = "ORDER BY Address $ord";
  }   
  if($_REQUEST['age']=='Date_of_Birth') {      
    $order = "ORDER BY Date_of_Birth  $ord";
  }   
  if($_REQUEST['age']=='Phone') {      
    $order = "ORDER BY Phone $ord";
  }
  if($_REQUEST['age']=='User_code') {      
    $order = "ORDER BY User_code $ord";
  } 
 return $query = mysqli_query($link, "SELECT * FROM `users` $order");
}
function PC_sort($ord) {
    global $link;
    if($_REQUEST['age']=='ID') {      
      $order = "ORDER BY ID $ord";
    }    
    if($_REQUEST['age']=='PC_name') {      
      $order = "ORDER BY PC_name $ord";
    }   
    if($_REQUEST['age']=='Characteristic') {      
      $order = "ORDER BY Characteristic $ord";
    }   
    if($_REQUEST['age']=='IMG') {      
      $order = "ORDER BY IMG  $ord";
    }   
    if($_REQUEST['age']=='Category') {      
      $order = "ORDER BY Category $ord";
    }
    if($_REQUEST['age']=='Price') {      
      $order = "ORDER BY Price $ord";
    } 
    if($_REQUEST['age']=='Quantity') {      
        $order = "ORDER BY Quantity $ord";
      } 
   return $query = mysqli_query($link, "SELECT * FROM `pc` $order");
  }
  function orders_sort($ord) {
    global $link;
    if($_REQUEST['age']=='ID') {      
      $order = "ORDER BY ID $ord";
    }    
    if($_REQUEST['age']=='PC_code') {      
      $order = "ORDER BY PC_code $ord";
    }   
    if($_REQUEST['age']=='User_code') {      
      $order = "ORDER BY User_code $ord";
    }   
    if($_REQUEST['age']=='Delivery_date') {      
      $order = "ORDER BY Delivery_date $ord";
    }   
    if($_REQUEST['age']=='Purchase_date') {      
      $order = "ORDER BY Purchase_date $ord";
    }
   return $query = mysqli_query($link, "SELECT * FROM `orders` $order");
  }
