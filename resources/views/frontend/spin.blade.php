<!DOCTYPE html>
<html>
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap, style , Responsive CSS Files  -->
<link rel="stylesheet" href="{{ asset('public/css/bootstrap.min.css')}}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('public/style.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('public/css/responsive.css')}}">
<!-- Font Awesome 5 KIT Script -->
<script src="https://kit.fontawesome.com/a282321041.js" crossorigin="anonymous"></script>
<style>
        body {
  background-color: black;
  display: grid;
  place-items: center;
  height: 100vh;
  margin: 0;
}

p {
  margin: 0;
  color: snow;
  font-size: 20px;
  font-weight: 300;
  text-align: center;
}

.button {
  display: block;
  width: 150px;
  font-size: 18px;
  font-weight: 200;
  margin: 10px auto 0 auto;
  border: 1px snow dashed;
  border-radius: 5px;
  color: snow;
  background-color: black;
  text-align: center;
}

.number {
  display: block;
}

.random-resolved {
  color: yellow;
}

@media (min-width: 768px) {
  p {
    font-size: 60px;
  }
}
     </style>
<title>CMMI QR | Booking</title>
</head>
<body>
    <section class="page-section">
            <!-- Navigation-->
            <div class="payment-page">
            	@include('frontend.layouts.navbar')
              <div class="container-fluid">
              	@if(session()->has('success'))
                  <div class="alert alert-success">
                      {{ session()->get('success') }}
                  </div>
              @endif
              @if(session()->has('error'))
                  <div class="alert alert-danger">
                      {{ session()->get('error') }}
                  </div>
              @endif
              
              <main>
      <p>Member ship no: <span class="number slow"></span></p>
      <div class="button">Choose Winner</div>
    </main>
              </div>
              </div>
              </section>
              
    
    
<script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
<script>
   "use strict";

function createRandomSpan() {
  const newDigit = document.createElement("span");
  return newDigit;
}

function getRandom(nonZero) {
  return nonZero
    ? Math.floor(Math.random() * 9) + 1
    : Math.floor(Math.random() * 10);
}

function createRandomNumbersTo(parentNode) {
  if (!parentNode) {
    throw new Error("Must be a valid parent node");
  }
  return function (digits, nextDigitTimeGap, digitSettledTime) {
    let isValid = (number) => Number.isSafeInteger(+number) && +number > 0;

    if (
      !isValid(digits) ||
      !isValid(nextDigitTimeGap) ||
      !isValid(digitSettledTime)
    ) {
      throw new Error("Arguments must be positive integer");
    }

    if (digitSettledTime <= 10) {
      throw new Error("digitSettledTime must be greater than 10 milliseconds");
    }

    return new Promise((resolve, reject) => {
      function getFinalNumber() {
        parentNode.classList.add("random-resolved");
        let number = parentNode.innerText;
        parentNode.innerHTML = number;
        if (!Number.isSafeInteger(+number)) {
          resolve(BigInt(number));
          return;
        }
        resolve(+number);
      }

      function gerenateNumber(speed, endTime, nonZero = false) {
        let newDigit = createRandomSpan();
        parentNode.prepend(newDigit);
        let digitId = setInterval(() => {
          if (shouldStop()) {
            clearInterval(digitId);
            return;
          }
          endTime -= speed;
          let randomNumber = getRandom(nonZero);
          if (endTime > 0) {
            newDigit.textContent = randomNumber;
            return;
          }
          newDigit.classList.add("random-resolved");
          clearInterval(digitId);
        }, speed);
      }
      let digit = 1;
      let isLastDigit = () => digit === digits;

      function generateDigit() {
        if (shouldStop()) {
          clearInterval(genRandomNumberId);
          return;
        }
        if (isLastDigit()) {
          gerenateNumber(2, digitSettledTime, true);
          setTimeout(() => {
            getFinalNumber();
          }, digitSettledTime);
          clearInterval(genRandomNumberId);
          return;
        }
        gerenateNumber(2, digitSettledTime);
        digit++;
      }

      let genRandomNumberId = setInterval(generateDigit, nextDigitTimeGap);
      generateDigit(); //remove first interval delay
    });
  };
}

function prependRandomNumbersTo(selector) {
  if (typeof selector !== "string" || !selector.length) {
    throw new Error("Selector should be non-empty string");
  }
  const element = document.querySelector(selector);
  return createRandomNumbersTo(element);
}

function shouldStop() {
  return stop;
}
function resetAll() {
  stop = true;
  let numbers = [...document.querySelectorAll(".number")];
  numbers.forEach((number) => {
    number.textContent = "";
    number.classList.remove("random-resolved");
  });
  setTimeout(() => {
    main();
  }, 1000);
}

function main() {
  stop = false;
  prependRandomNumbersTo(".slow")(4, 500, 1000).then((n) =>
    console.log(`resolved (slow):`, n)
  );
}

let stop = false;
const button = document.querySelector(".button");
button.addEventListener("click", resetAll);

main();
</script>
</body>
</html>