<?php
include 'db.php';

if (isset($_POST['submit'])) {
  // Certificate of Enrollment (COE)
  $coe = $_FILES['coe']['name'];
  $coe_tmp_name = $_FILES['coe']['tmp_name'];

  // Birth Certificate (BC)
  $birthc = $_FILES['birthc']['name'];
  $birthc_tmp_name = $_FILES['birthc']['tmp_name'];

  // Directory where files will be saved
  $uploadDir = 'images-coe-birthc/';

  // Path for each file
  $coe_dest = $uploadDir . basename($coe);
  $birthc_dest = $uploadDir . basename($birthc);

  // Insert the image file names into the database
  $query = "INSERT INTO `images-coe-birthc` (coe, birthc) VALUES ('$coe', '$birthc')";
  $result = mysqli_query($conn, $query);

  // Move the uploaded files to the server directory
  if (move_uploaded_file($coe_tmp_name, $coe_dest) && move_uploaded_file($birthc_tmp_name, $birthc_dest)) {
    echo "Files uploaded and saved successfully!";
  } else {
    echo "Failed to upload files.";
  }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Register - SB Admin</title>
  <link href="css/styles.css" rel="stylesheet" />

  <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
  <!-- <script src="/js/validate.js" defer></script> -->
</head>

<body class="bg-dark" style="--bs-bg-opacity: .95;">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
      <main>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-7">
              <div class="card shadow-lg border-0 rounded-lg mt-5 bg-dark">
                <div class="card-header">
                  <h3 class="text-center font-weight-light my-4 text-light">Fill up</h3>
                </div>


                <div class="card-body">
                  <form class="" action="" method="post" id="" autocomplete="off" enctype="multipart/form-data">
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                          <input class="form-control" id="fName" name="fName" type="text" required value="" placeholder="Enter your first name" />
                          <label for="fName">First name</label>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-floating">
                          <input class="form-control" id="lName" name="lName" type="text" required value="" placeholder="Enter your last name" />
                          <label for="lName">Last name</label>
                        </div>
                      </div>
                    </div>



                    <div class="form-floating mb-3">
                      <input class="form-control" id="address" name="address" type="address" required value="" placeholder="address" />
                      <label for="address">Address</label>
                    </div>

                    <div class="form-floating mb-3">
                      <label for="coe" style="font-size: 1.2rem; position: absolute; top: -10px;">
                        Photo of Certificate of Enrollment
                      </label>
                      <input class="form-control" id="coe" name="coe" type="file" required
                        accept="image/*" style="height: 100px; font-size: 1.0rem; padding: 50px;">
                    </div>

                    <div class="form-floating mb-3">
                      <label for="birthc" style="font-size: 1.2rem; position: absolute; top: -10px;">
                        Photo of Birth Certificate
                      </label>
                      <input class="form-control" id="birthc" name="birthc" type="file" required
                        accept="image/*" style="height: 100px; font-size: 1.0rem; padding: 50px;">
                    </div>
                    <div>
                      <?php
                    $res = mysqli_query($conn, "SELECT * FROM images-coe-birthc");
                    while ($row = mysqli_fetch_assoc($res)) {
                    ?>
                       <h3>Certificate of Enrollment</h3>
                       <img src="images-coe-birthc/<?php echo $row['coe']; ?>" alt="COE" style="max-width: 300px;">

                       <h3>Birth Certificate</h3>
                       <img src="images-coe-birthc/<?php echo $row['birthc']; ?>" alt="Birth Certificate" style="max-width: 300px;">
                       <?php
                        }
                          ?>

                    </div>
                    








                    <div class="mt-4 mb-0 text-center">
                      <button type="submit" name="submit" class="btn btn-success btn-block">Submit</button>
                    </div>
                  </form>
                  </form>
                </div>


                <div class="card-footer text-center py-3">
                  <div class="small"><a href="home.php" class="text-muted">Go Back</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
    <div id="layoutAuthentication_footer">
      <footer class="py-4 bg-light mt-auto bg-dark">
        <div class="container-fluid px-4">
          <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; Your Website 2023</div>
            <div>
              <a href="#" class="text-muted">Privacy Policy</a>
              &middot;
              <a href="#" class="text-muted">Terms &amp; Conditions</a>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
</body>

</html>