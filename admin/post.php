<?php include "header.php"; ?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <div class="col-md-12">

              <?php 
                //pagination creat start
                include "config.php";
                $limit = 3;
                if(isset($_GET['page'])){
                    $page = $_GET['page'];
                }else{
                    $page = 1;
                }
                $offset = ($page -1) * $limit;
                //pagination creat end

                // admin all data categery check start

                if($_SESSION ["user_role"]== '1'){
                $sql = "SELECT  post.post_id, post.title, post.description,post.post_date,
                category.category_name,user.username FROM post 
                LEFT JOIN category ON post.category = category.category_id
                LEFT JOIN user ON post.author = user.user_id
                ORDER BY post.post_id DESC LIMIT {$offset},{$limit}";
                }

                // admin all data categery check end


                // localuser data categery check start
                
                elseif($_SESSION ["user_role"]== '0'){
                    $sql = "SELECT  post.post_id, post.title, post.description,post.post_date,
                category.category_name,user.username FROM post 
                LEFT JOIN category ON post.category = category.category_id
                LEFT JOIN user ON post.author = user.user_id
                WHERE post.author = {$_SESSION['user_id']}
                ORDER BY post.post_id DESC LIMIT {$offset},{$limit}";
                }

                // localuser data categery check end

                //database and table data add user connection  start

                
                $result = mysqli_query($connection , $sql) or die("Query Failed.");
                if(mysqli_num_rows($result) > 0){
                
                ?>

                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody> <?php while($row = mysqli_fetch_assoc($result)){?>
                          <tr>
                              <td class='id'><?php echo $row['post_id'];?></td>
                              <td><?php echo $row['title'];?></td>
                              <td><?php echo $row['category_name'];?></td>
                              <td><?php echo $row['post_date'];?></td>
                              <td><?php echo $row['username'];?></td>
                              <td class='edit'><a href='update-post.php?id =<?php echo $row['post_id'];?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-post.php?id =<?php echo $row['post_id'];?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                          <?php }?>
                      </tbody>
                  </table>
                  <?php }
                  //database and table data add user connection end


                  // pagination creat dynamic start

                  $sql1 = "SELECT * FROM post";
                  $result1 = mysqli_query($connection,$sql1) or die ("Query Failed.");

                  if(mysqli_num_rows($result1) > 0){


                    $totat_records = mysqli_num_rows($result1);
      
                    $total_page = ceil($totat_records / $limit);
                    echo "<ul class='pagination admin-pagination'>";
                    if($page>1){
                        echo '<li><a href="post.php?page= '.($page - 1).'">prev</a></li>';
                    }
                    
                    for($i = 1; $i <= $total_page; $i++){
                        if($i == $page){
                            $active = "active";
                        }else{
                            $active = "";
                        }
                        echo ' <li class= " '.$active.'"><a href= "post.php?page='.$i.'">'.$i.'</a></li>';
                    }
                    if($total_page > $page){
                        echo  '<li><a href="post.php?page= '.($page + 1).'">Next</a></li>';
                    }
                    
                    echo '</ul>';
                  }
                  ?>
                  <!-- pagination creat dynamic end -->
                  <!-- <ul class='pagination admin-pagination'>
                      <li class="active"><a>1</a></li>
                      <li><a>2</a></li>
                      <li><a>3</a></li>
                  </ul> -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
