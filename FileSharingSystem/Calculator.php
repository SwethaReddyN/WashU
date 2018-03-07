<!DOCTYPE html>

<html>
  <head>
    <title>Simple Calculator</title>
    <link rel = "stylesheet" type = "text/css" href = "Calculator.css">
  </head>
  
  <body>
    <script>
      var operands = ["", ""]; //user entered numbers will be appended and stored as operand1 and operand2
      var index = 0; //which operand is being processed currently
      var operator = ""; //user selected operator

      //Takes individual button clicks and creates an operand
      function handleNumbers() {
 
        operands[index] = operands[index] + event.target.value;
        document.getElementById("input" + (index + 1)).value = operands[index];
      }
			
      //Checks if an operand is enterd before entering an operator
      //0 as first operand is not accepted
      function handleOperators() {
			
        if(operands[0] === "" || Number(operands[0]) === 0) {

          alert("Enter number first");
          event.target.checked = false;
        } else {

          index = 1;
          operator = event.target.value;
        }
      }

      //Handles form validation and submits the form.
      //Following validation are done :
      //Second operand must be entered 
      //If operator is /, then second operator cannot be 0
      function handleForm() {
			                        
        if(operands[1] == "") {
 
          //second number not entered. So form is not submitted
          alert("Enter Second Number");	        
        } else if(operator === "/" && (Number(operands[1]) === 0)) {
			              
          //Divide by zero exception. So form is not submitted
          alert("Can't divide a number by 0. Enter some other number for divisor");
        } else {
          //reset values and submit form
          index = 0;
          operands[0] = operands[1] = "";
          document.getElementById("calForm").submit();
        }
      }
    </script> 
		
    <!-- php contents are displayed in iframe" -->
    <form id = "calForm" action = "#" method = "POST" target = "ifr">   
      <div>
        <table>
          <tr>
            <td>
              <!-- iframe to display results -->
              <iframe src = "ifr.htm" id = "ifr" name = "ifr"></iframe>
            </td>
          </tr>
          <tr>
            <td>
              <input type = "button" class = "number" value = "7" onclick = "handleNumbers();">
              <input type = "button" class = "number" value = "8" onclick = "handleNumbers();">
              <input type = "button" class = "number" value = "9" onclick = "handleNumbers();">
              <input type = "radio" name = "operator" value = "/" onclick = "handleOperators();">/
            </td>
          </tr>
          <tr>
            <td>
              <input type = "button" class = "number" value = "4" onclick = "handleNumbers();">
              <input type = "button" class = "number" value = "5" onclick = "handleNumbers();">
              <input type = "button" class = "number" value = "6" onclick = "handleNumbers();">
              <input type = "radio" name = "operator" value = "*" onclick = "handleOperators();">*
            </td>
          </tr>
          <tr>
            <td>
              <input type = "button" class = "number" value = "1" onclick = "handleNumbers();">
              <input type = "button" class = "number" value = "2" onclick = "handleNumbers();">
              <input type = "button" class = "number" value = "3" onclick = "handleNumbers();">
              <input type = "radio" name = "operator" value = "-" onclick = "handleOperators();">-
            </td>
          </tr>
          <tr>
            <td>
              <input type = "button" class = "number" value = "0" onclick = "handleNumbers();">
              <input type = "button" class = "number" value = "00" onclick = "handleNumbers();">
              <input type = "button" class = "calculate" name = "calculate" value = "=" onclick = "handleForm();">
              <input type = "radio" name = "operator" value = "+" onclick = "handleOperators();">+
            </td>
          </tr>
        </table>
        <!-- hidden inputs to hold operand1 and operand2. php will get the values from these elements -->
        <input id = "input1" class = "hidden" name = "input1">
        <input id = "input2" class = "hidden" name = "input2">
      </div>
    </form>
    <?php
      if($_SERVER['REQUEST_METHOD'] == 'POST') {
	
        //Get values from post
        $operator = $_POST['operator'];
        $op1      = (int)$_POST['input1'];
        $op2      = (int)$_POST['input2'];
	                
        //No free format user input, so did no "Escaping Output"
        $inputInfo = sprintf("%d%s%d =", $op1, $operator, $op2);
        //Do the math
        switch($operator) {
   
          case "/" :
            printf("%s %f", $inputInfo, ($op1 / $op2));
            break;
          case "*" :
            printf("%s %d", $inputInfo, ($op1 * $op2));
            break;
          case "+" :
            printf("%s %d", $inputInfo, ($op1 + $op2));
            break;
          case "-" :
            printf("%s %d", $inputInfo, ($op1 - $op2));
            break;
        }
      }
    ?> 
  </body>
</html>