var label;
var target;
var checkMark = "fa-check";
var iconSize = 'fa-2x';

function Form(){

}

Form.prototype.alterForm= function(){
    
    $('input').focus(function(e){
        form.setLabel(e.target);
        form.checkFocused();
    });
    $('input').focusout(function(e){
        form.setLabel(e.target);
        form.checkUnfocused(e.target);
    });
};

Form.prototype.setLabel = function(target){
    label= $('label[for='+target.id+']');
};

Form.prototype.getLabel = function(){
    return label;
};

Form.prototype.checkFocused= function(){
    form.getLabel().addClass('active','');
};

Form.prototype.checkUnfocused= function(target){
    if($(target).val().length == 0){
        form.getLabel().removeClass('active');
    }else if(!$(form.getLabel()).next().is($(checkMark))){
    }
};

form = new Form();

function initialize(){
    form.alterForm();
}
initialize();