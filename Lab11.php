<?php
    $mysqli = new mysqli("localhost","software","123456789","travel");
    if($mysqli->connect_errno){
        echo "Failed to connect to MySQL".$mysqli->connect_error;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Lab11</title>

      <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    
    

    <link rel="stylesheet" href="css/captions.css" />
    <link rel="stylesheet" href="css/bootstrap-theme.css" />    

</head>

<body>
    <?php include 'header.inc.php'; ?>
    


    <!-- Page Content -->
    <main class="container">
        <div class="panel panel-default">
          <div class="panel-heading">Filters</div>
          <div class="panel-body">

            <form action="Lab11.php" method="get" class="form-horizontal">
              <div class="form-inline">
              <select name="continent" class="form-control">
                <option value="0">Select Continent</option>
                <?php
                $result = $mysqli->query("SELECT * FROM Continents");

                while($row = $result->fetch_assoc()) {
                  echo '<option value=' . $row['ContinentCode'] . '>' . $row['ContinentName'] . '</option>';
                }

                ?>
              </select>     
              
              <select name="country" class="form-control">
                <option value="0">Select Country</option>
                <?php
                $result1 = $mysqli->query("SELECT * FROM Countries");

                while($row = $result1->fetch_assoc()) {
                    echo '<option value=' . $row['ISO'] . '>' . $row['CountryName'] . '</option>';
                }
                ?>
              </select>    
              <input type="text"  placeholder="Search title" class="form-control" name=title>
              <button type="submit" class="btn btn-primary">Filter</button>
              </div>
            </form>

          </div>
        </div>     
                                    

		<ul class="caption-style-2">
            <?php
            /*因个人理解，认为洲与国的选择是相互制约的，难以分开书写，所以没有分成不同的方法，简述逻辑。
            1.洲如果未赋值，则为刚进页面的情况，应该加载所有图片；
            2.洲已赋值：若洲0国0，则加载全部；若洲0国有值，则按国加载；
                       若洲有值国0，则按洲加载；若洲有值国有值，则依然按国加载。
            */
                if (isset($_GET["continent"])) {
                    $continent = $_GET["continent"];
                    $country=$_GET["country"];
                    if ($continent == "0") {
                        if($country=="0") {
                            $sql = "SELECT * FROM ImageDetails";
                            find($mysqli, $sql);
                        }else{
                            $sql="SELECT * FROM ImageDetails WHERE CountryCodeISO='$country'";
                            find($mysqli,$sql);
                        }
                    } else {
                        if($country =="0") {
                            $sql = "SELECT * FROM ImageDetails WHERE ContinentCode='$continent'";
                            find($mysqli, $sql);
                        }else{
                            $sql="SELECT * FROM ImageDetails WHERE CountryCodeISO='$country'";
                            find($mysqli,$sql);
                        }
                    }
                } else {
                    $sql="SELECT * FROM ImageDetails";
                    find($mysqli,$sql);
                }
             //根据不同情况的sql语句执行加载图片的操作
            function find($mysqli,$sql){
                $selectres = $mysqli->query($sql);
                while ($row = $selectres->fetch_assoc()) {
                    $id = $row["ImageID"];
                    $path = $row["Path"];
                    $alt = $row["Title"];
                    $p = $row["Description"];
                    $display = <<< DIS
            <li>
              <a href="detail.php?id=$id" class="img-responsive">
                <img src="images/square-medium/$path" alt="$alt">
                <div class="caption">
                  <div class="blur"></div>
                  <div class="caption-text">
                    <p>$p</p>
                  </div>
                </div>
              </a>
            </li>
DIS;
                    echo $display;
                }
            }

            ?>
       </ul>       

      
    </main>
    
    <footer>
        <div class="container-fluid">
                    <div class="row final">
                <p>Copyright &copy; 2017 Creative Commons ShareAlike</p>
                <p><a href="#">Home</a> / <a href="#">About</a> / <a href="#">Contact</a> / <a href="#">Browse</a></p>
            </div>            
        </div>
        

    </footer>


        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>