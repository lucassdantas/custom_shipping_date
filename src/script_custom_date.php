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
                let showShippingDateByShippingType = (shippingType, shippingDate) => {
                    if(shippingType.selectedIndex !== 2){
                        shippingDate.style.display = 'none'
                    }else{
                        shippingDate.style.display = ''
                    }
                }
                showShippingDateByShippingType(shippingType, shippingDateField)
                shippingDateField.querySelector('.optional').innerHTML = ''
                let shippingDateInput = shippingDateField.querySelector('input')
                
                shippingType.addEventListener('change', e => {
                    showShippingDateByShippingType(shippingType, shippingDateField)
                })
                shippingDateInput.addEventListener('change', e => {
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
<script>
    if(location.pathname === '/finalizar-compra/'){
        let setCheckListener = (element) => {
            if(element.checked === true){
                console.log('checked = true')
                let tryReloadPage = id => {
                    let element = document.querySelector("#"+id)
                    if(!element.checked){ 
                        location.reload()
                        return true
                    }
                    return false
                },
                clearReloadInterval = (interval) => {
                    if(tryReloadPage('shipping_method_0_free_shipping6')) clearInterval(interval)
                },
                reloadPageInterval = setInterval(tryReloadPage, 1200, 'shipping_method_0_free_shipping6' );
                setInterval(clearReloadInterval, 500, reloadPageInterval)
            }
        },
        motoboyShipping = document.querySelector("#shipping_method_0_free_shipping6")
        
        motoboyShipping.addEventListener('click', (e) => {
            e.preventDefault()
            location.reload();
        })

        setCheckListener(motoboyShipping)
    }
</script>
<?php
}

add_action('wp_footer', 'script_custom_date');
