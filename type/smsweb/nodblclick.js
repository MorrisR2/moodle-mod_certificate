function noDblClick(event) {
    elem = this;
    elem.set('disabled', true);
    oldtext = this.get('value');
    elem.set('value', 'Loading ...')
    spin = setInterval(function() { elem.set( 'value', spinText('Loading') ) }, 500);
    setTimeout(function() { clearInterval(spin); elem.set('disabled', false); elem.set('value', oldtext); }, 4000);
}

function spinText(text) {
    if ( (typeof spinText.counter == 'undefined') || (spinText.counter == 5) ) {
        spinText.counter = 1;
    }
    return text + " " + Array(spinText.counter++).join(".");
}

