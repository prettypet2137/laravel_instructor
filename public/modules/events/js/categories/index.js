$('.form-delete').on('submit', function(){
  if(confirm("@lang('Delete this item ?')")){
      return true;
  }else{
      return false;
  }
});