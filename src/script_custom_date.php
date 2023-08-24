<?php
function script_custom_date()
{
?>
<script>
    
    if(location.pathname == '/finalizar-compra/'){
        let waitForElementToExist = (selector) => {
                return new Promise(resolve => {
                    if (document.querySelector(selector)) {
                        return resolve(document.querySelector(selector));
                    }

                    const observer = new MutationObserver(() => {
                        if (document.querySelector(selector)) {
                            resolve(document.querySelector(selector));
                            observer.disconnect();
                        }
                    });

                    observer.observe(document.body, {
                        subtree: true,
                        childList: true,
                    });
                });
            },
            ds = value => document.querySelector(value),
            c  = value => console.log(value),
            delivertTyleSelectTitle,
            date;

        waitForElementToExist('#shipping_type')
            .then( shippingType => {
                waitForElementToExist('#shipping_date_field')
                    .then(shippingDateField => {
                        shippingDateField.style.display = 'none'
                        shippingDateField.querySelector('.optional').innerHTML = ''
                        let shippingDateInput = shippingDateField.querySelector('input')
                        
                        shippingType.addEventListener('change', e => {
                            if(shippingType.selectedIndex !== 2){
                                shippingDateField.style.display = 'none'
                            }else{
                                shippingDateField.style.display = ''
                            }
                        })
                        shippingDateInput.addEventListener('change', e => {
                            console.log(shippingDateInput)
                            date = new Date(shippingDateInput.valueAsNumber)
                            if(date.getUTCDay() == 0){
                                shippingDateInput.value = ''
                                alert('Só realizamos entregas em dias úteis')
                            }
                        })
                    })
                })
    }
</script>

<?php
}

add_action('wp_footer', 'script_custom_date');
