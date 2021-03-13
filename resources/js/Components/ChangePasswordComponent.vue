<template>
<div>
    <div class="card">
        <div class="card-header">
            <h2 class="text-primary">{{ heading }}</h2>
        </div>
        <form @submit="changePassword">
            <div class="card-body">
                <div v-if="messages.length" v-for="message in messages">
                    <ul>
                        <li class="alert" v-bind:class="{'alert-success': hasSuccess, 'alert-danger':hasError}">{{ message }}</li>
                    </ul>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" v-model="optionPassword" id="customSwitchPassword">
                        <label class="custom-control-label" for="customSwitchPassword">Are you sure to change password?.</label>
                    </div>
                </div>
                <div v-if="optionPassword">
                    <label for="">Current Password:</label>
                    <input type="password" class="form-control" v-model="current_pass">

                    <label for="">New Password:</label>
                    <input type="password" class="form-control" v-model="new_pass">
                </div>
                <div v-else>
                    <label for="">Current Password:</label>
                    <input type="password" class="form-control" disabled v-model="current_pass" placeholder="*******">

                    <label for="">New Password:</label>
                    <input type="password" class="form-control" disabled v-model="new_pass">
                </div>

            </div>
            <div class="card-footer">
                <div v-if="optionPassword">
                    <button class="btn btn-success btn-sm float-right">Change</button>
                </div>
                <div v-else>
                    <button class="btn btn-success btn-sm float-right" disabled>Change</button>
                </div>
            </div>
        </form>
    </div>
</div>
</template>
<script>
 export default{
     data() {
         return {
            heading: 'Password Change',
            optionPassword: false,
            current_pass:null,
            new_pass:null,
            messages: [],
            hasSuccess: false,
            hasError:false,
         }
     },
     methods: {
         changePassword(e) {
            this.messages = [];
            this.hasSuccess = false,
            this.hasError = false,
            axios.post('/change-password', {
                current_pass: this.current_pass,
                new_pass: this.new_pass,
            }).then((resp) => {
                if(resp.data.response == true)
                {

                    this.messages = resp.data.message;
                    this.hasSuccess = true;
                    this.optionPassword = false;
                    this.current_pass = null;
                    this.new_pass = null;
                }
                else
                {
                    this.messages = resp.data.message;
                    this.hasError = true;
                }
            });
            e.preventDefault();
         }
     }
 }
</script>
