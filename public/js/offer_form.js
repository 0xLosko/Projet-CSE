document.addEventListener('DOMContentLoaded', () => {
    const typeOfferField = document.getElementById('offer_typeOffer');
    const sortNumberField = document.getElementsByClassName('TypeCanHide');
    for (const item of sortNumberField) {
        item.style.display = (typeOfferField.value == 0) ? 'flex' : 'none';
    }
    typeOfferField.addEventListener('change', function() {
        for (const item of sortNumberField) {
            item.style.display = (this.value == 0) ? 'flex' : 'none';
        }
    });
});