<?php
require_once 'entrycon.php';

$res = data_display();

include("security.php");
include("header.php");
include("footer.php");
?>
<script>

function chkalert(id)
{
  var stat = confirm('Are you sure you want to delete this entry?');

  if(stat)
  {
    document.location.href = 'delete.php?del=' + id; // Concatenate the id parameter correctly
  }

}

</script>

<section class="home">
    <div class="container">
        <header class="running-underline">Entries</header>
    </div>
  
    <div class="forms">
        <form action="" method="post">
            <div class="fields">
                <div class="custom-search-container">
                    <select id="sector" name="sector">
                        <option value="" disabled selected>Filter By</option>
                        <option value="Assets">Assets</option>
                        <option value="Liabilities">Liabilities</option>
                        <option value="Owner Equity">Owner's Equity</option>
                    </select>
                    <button type="filter"><i class='bx bx-filter-alt'></i></button>

                    <input type="text" name="search" id="type" class="custom-search-input" placeholder="Search..." autocomplete="off">
                    <!--<button class="searches" type="searches"><i class="bx bx-search"></i></button>-->
                </div>        
            </div>
        </form>
    </div>
    

    <form action="" method="post">
        <?php if ($res && mysqli_num_rows($res) > 0): ?>
            <div class="form first">
                <div class="table-container">
                    <table id="entry" class="my">
                        <thead>
                            <th> Date </th>
                            <th>Amount</th>
                            <th>Account Name</th>
                            <th>Description</th>
                            <th colspan="2">Action</th>
                        </thead>
                        <tbody id="table-data">
                            <?php while($row = mysqli_fetch_assoc($res)){
                                $id = $row['tNo'];
                                $date = $row['tDate'];
                                $des = $row['description'];
                                $acc = $row['accName'];
                                if($row['amount']<0)
                                {
                                    $amount = -1*$row['amount'];
                                }
                                else
                                {
                                    $amount = $row['amount'];
                                }
                                echo'<tr>
                                <td id=""> '.$date.'</td>
                                <td id="table-row">'.$amount.'</td>
                                <td id="table-row">'.$acc.'</td>
                                <td id="table-row">'.$des.'</td>
                                <td><button type="edit"><a href="edit.php?editid= '.$id.'">Edit</a></button></td>
                                <td><button type="delete"><a href="javascript:void()" onClick="chkalert('.$id.')">Delete</a></button></td>
                                </tr>
                                ';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <p style="color: red; margin-left: 55px"><b>No data available.</b></p>
        <?php endif; ?>
    </form>
</section>

<script>
// Check if the URL parameter for successful deletion is present
const urlParams = new URLSearchParams(window.location.search);
const deleteSuccess = urlParams.has('delete_success');

// If successful deletion, display confirmation alert
if (deleteSuccess) {
    alert("Entry deleted successfully!");
}
</script>