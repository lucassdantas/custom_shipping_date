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
        }
        let statusCheckerAndReload = {
            element: document.querySelector("#shipping_method_0_free_shipping6"),
            wasChecked: false,
            isReloading: false,
            isCheckedInterval:() => {
                waitForElementToExist("#shipping_method_0_free_shipping6").then(el => {
                    if(el.checked === true) {
                        statusCheckerAndReload.wasChecked = true
                        return true 
                    }
                    return false
                })
            },
            tryReloadPage() {
                setInterval( () => {
                    if(statusCheckerAndReload.wasChecked){
                        statusCheckerAndReload.element = document.querySelector('#shipping_method_0_free_shipping6')
                        if(!statusCheckerAndReload.element.checked){
                            statusCheckerAndReload.isReloading = true  
                            location.reload()
                            clearInterval(statusCheckerAndReload.tryReloadPage)
                            return true
                        }
                        return false
                    } else{
                        statusCheckerAndReload.element = document.querySelector('#shipping_method_0_free_shipping6')
                        if(statusCheckerAndReload.element.checked){
                            statusCheckerAndReload.isReloading = true  
                            location.reload()
                            clearInterval(statusCheckerAndReload.tryReloadPage)
                            return true
                        }
                    }
                }, 1000)
            },
            init(){
                statusCheckerAndReload.isCheckedInterval()
                statusCheckerAndReload.tryReloadPage()
            }
        }
        statusCheckerAndReload.init()
        /*
        let setCheckListeners = (element) => {
            if(element.checked === true){
                let isReloading = false,
                tryReloadPage = id => {
                    let element = document.querySelector("#"+id)
                    if(!element.checked){
                        isReloading = true  
                        location.reload()
                        return true
                    }
                    return false
                },
                reloadPageInterval = setInterval(tryReloadPage, 1000, 'shipping_method_0_free_shipping6' ),
                clearReloadInterval = () => {
                    if(isReloading) clearInterval(reloadPageInterval)
                };
                setInterval(clearReloadInterval, 500)
            }
        },
        motoboyShipping = document.querySelector("#shipping_method_0_free_shipping6")
        setCheckListeners(motoboyShipping)*/
    }
</script>
<?php
}

add_action('wp_footer', 'script_custom_date');
