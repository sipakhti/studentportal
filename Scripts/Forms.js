class Forms {


    static async validateSignupForm(e) {
        console.log(e);
        alert(e)
        e.preventDefault();
        return;
        let signupForm = document.forms['signupForm'];

        signupForm.addEventListener('submit', validateSignupForm);
        if (signupForm['password'].value.trim() !== signupForm['confirmPassword'].value.trim()) {
            alert('pass mismatch')
            e.preventDefault();
            return false;
        }
        let data = {};
        const formData = new FormData(signupForm);
        for (const [key, value] of formData) {
            data[key] = value
        }
        let res = await fetch('signup.php', {
            method: 'POST',
            body: JSON.stringify(formData)
        });

        console.log(res)

    }

    

}