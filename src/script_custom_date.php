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
        statusCheckerAndReload = {
            motoboyInputId:'shipping_method_0_free_shipping6',
            element: document.querySelector(`#${statusCheckerAndReload.motoboyInputId}`),
            wasChecked: false,
            isReloading: false,
            checker: undefined,
            radioBtns: document.querySelectorAll('.woocommerce-shipping-totals input'),
            isCheckedInterval(){
                waitForElementToExist(`#${statusCheckerAndReload.motoboyInputId}`).then(el => {
                    if(el.checked === true) {
                        statusCheckerAndReload.wasChecked = true
                        return true 
                    }
                    return false
                })
            },
            tryReloadPage() {
                statusCheckerAndReload.checker = setInterval( () => {
                    if(statusCheckerAndReload.wasChecked){
                        waitForElementToExist(`#${statusCheckerAndReload.motoboyInputId}`).then(el => {
                            console.log("estava ativo")
                            if(!el.checked){
                                waitForElementToExist('#shipping_method_0_correios-sedex14').then(el => {
                                    statusCheckerAndReload.isReloading = true  
                                    location.reload()
                                    clearInterval(statusCheckerAndReload.checker)
                                })
                            }
                        })
                    } else{
                        waitForElementToExist(`#${statusCheckerAndReload.motoboyInputId}`).then(el => {
                            console.log("estava inativo")
                            if(el.checked){
                                waitForElementToExist('#shipping_method_0_correios-sedex14').then(el => {
                                    statusCheckerAndReload.isReloading = true  
                                    location.reload()
                                    clearInterval(statusCheckerAndReload.checker)
                                })
                            }
                        })
                    }
                }, 1200)
            },
            reloadOnClick(){
                statusCheckerAndReload.radioBtns = document.querySelectorAll('.woocommerce-shipping-totals input')
                statusCheckerAndReload.radioBtns.forEach(btn => {
                    btn.addEventListener('click', () => {
                        waitForElementToExist(`#${statusCheckerAndReload.motoboyInputId}`).then((el) => {
                            location.reload()
                        })
                    })
                })
            },
            init(){
                statusCheckerAndReload.isCheckedInterval()
                statusCheckerAndReload.tryReloadPage()
            }
        }
        statusCheckerAndReload.init()
    }
</script>
<?php
}

add_action('wp_footer', 'script_custom_date');
