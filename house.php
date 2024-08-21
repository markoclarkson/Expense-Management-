<? php
    include ("configuration.php");
?>
<!DOCTYPE html>
<html>
<head>
<style type="text/css">
    body {
    background: #594F4F;
    background: -moz-linear-gradient(-45deg, #1d4946  10%, #594F4F 100%);
    background: -webkit-linear-gradient(-45deg, #1d4946  10%, #594F4F    100%);
    background: linear-gradient(200deg, #1d4946  10%, #594F4F 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1d4946 ', endColorstr='594F4F   ', GradientType=1 );
}
.main {
    border: 2px solid black;
    border-radius: 30px;
    margin-left: 30%;
    margin-right: 30%;
    padding-bottom: 20px;
    
}
.hero {
    background-size: cover;
    display: flex;
    justify-content: center;
    text-align: center;
}
input {
    margin: 15px auto;
    display: block;
    width: 50%;
    padding: 8px;
}
.bg-modal{
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
}
ul {
    background-color: gray;
}

li {
    display: inline-flex;
}

h1 {
    text-align: center;
    border: 3px solid black;
    font-size: 42px;
    padding: 20px;
}

h2 {
    text-align: center;
    text-decoration: underline;
}

h3 {
    text-align: center;
    font-size: 25px;
}

.dropbtn {
  background-color: #4CAF50;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}
.buttons {
    background-color: black;
    border: 2px solid white;
    border-radius: 30px;
    text-decoration: none;
    padding: 10px 28px;
    color: white;
    margin-top: 10px;
    display: inline-flex;
}
.button {
    text-decoration: none;
    padding: 10px 28px;
    color: white;
    display: inline-flex;
}

.button:hover {
    background-color: green;
}


img {
    height: 80px;
    width: 80px;
}
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #f1f1f1}

.dropdown:hover .dropdown-content {
  display: block;
}

.dropdown:hover .dropbtn {
  background-color: #3e8e41;

}
</style>
</head>
<body>
    <section>
        <header>
            <ul>
                <li><a type="button" class="button" href="home.html">Home</a></li>
                <li><a type="button" class="button" href="goal.php">Goals</a></li>
            </ul>
        </header>
        <section class="main">

            <div class="hero">
                <div>
                    <h1 class="text-center">House</h1>
                </div>
            </div>


            <div class="bg-modal">
                        <form action="configuration.php" method="POST">
                            <h2>Add Your Money to wallet.</h2>
                            <input  name="goal" type="hidden" value="House" required>
                            <input type="text" name="comment" id="text" placeholder="Enter Note: ">
                            <input  name="amount" id="amount" type="number" min="0" placeholder="Enter the amount." required>
                            <button name="submit" type="submit" class="buttons">Submit</button> 
                        </form>
                </div>

        </section>
    </section>
</body>
</html>
