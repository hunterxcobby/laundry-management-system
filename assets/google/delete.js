function DelConfirm()
{	var answer=confirm("Are you Sure To Delete This Records?");
  if(answer)
  { return true; }
  else
  {  return false; 
  }
}

function DelallConfirm()
{	var answer=confirm("Delete All Records This Vendor?");
  if(answer)
  { return true; }
  else
  {  return false; 
  }
}