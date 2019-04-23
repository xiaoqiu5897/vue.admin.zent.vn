<template>
	<div id="login-form">
		<form action="" method="POST" role="form" >
			<h1>Login</h1>
			<div class="form-group">
				<label for="" class="name-input">Email</label>
				<input 
						type="email" 
						class="form-control" 
						id="email" 
						v-model="email" 
						required
						>
			</div>
			<div class="form-group">
				<label for="" class="name-input">Password</label>
				<input 	
						type="password" 
						class="form-control" 
						id="password" 
						v-model="password" 
						required
						>
			</div>
			<button type="submit" class="btn btn-warning" id="btn-login" @click.prevent="submited" >Submit</button>
		</form>
	</div>
</template>
<script>
import Vue from 'vue'

export default {
  data: function () {
    return {
      email: '',
      password: '',
      error: false
    }
  },
  methods: {
    submited: function () {
    	axios.post('/api/login', {email: this.email, password: this.password})
                .then(response => {
                    console.log(response)
                    this.$router.replace(this.$route.query.redirect || '/dashboard')
                })
                .catch(error => {
                    console.log(error)
                })
    }
  }
}
</script>
<style type="text/css">
	#login-form {
		width: 500px;
		padding: 20px;
		background-color: #2d2d2d;
		margin: auto;
		margin-top: 200px;
		border: 0px;
		color: white;
	}
	h1{
		margin-bottom: 50px;
		text-align: center;
	}
	input{
		margin-bottom: 30px;
		font-size: 14px;
	}
	label{
		font-size: 17px!important;
	}
	form{
		width: 90%;
	}
	#btn-login{
		margin-left: 170px;
	}
</style>