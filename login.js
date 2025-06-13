function validateLoginForm(){
    console.log('validateLoginForm() called');
    const email =document.getElementById('email').value;
    const password =document.getElementById('password').value;

    console.log('Email:', email); 
    console.log('Password:', password); 
    console.log('Password length:', password.length);
    
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if(!emailPattern.test(email)){
        alert('Please enter a valid email address.');
        return false;
    }
    if(password.length < 6){
        alert('Password must be at least 6 characters long.');
        return false;
    }
    return true;
}