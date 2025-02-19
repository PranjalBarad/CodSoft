let num = "";
let buttons = document.querySelectorAll('.btn');

Array.from(buttons).forEach((btn) => {
    btn.addEventListener('click', (e) => {
        if (e.target.innerHTML === '=') {
            try {
                num = eval(num);
            }
            catch (error) {
                num = "Error";
            }
            document.querySelector('.display input').value = num;
        }

        else if (e.target.innerHTML == 'CE') 
        {
            num = num.slice(0, -1);
            document.querySelector('.display input').value=num;
        }

        else if (e.target.innerHTML == 'C') 
        {
            num = "";
            document.querySelector('.display input').value = num;
        }

        else
       {

            num += e.target.innerHTML;
            document.querySelector('.display input').value = num;
        }
    });
});
