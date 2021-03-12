<template>
        <div class="card">
        <div class="card-header text-primary">
            <h2>{{ heading }} </h2>
        </div>
        <form @submit="changeemail">
        <div class="card-body">
        <div v-if="message.length">
             <div class="alert alert-success">
               {{ message }}
             </div>
        </div>
            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" v-model="option" id="customSwitch1">
                    <label class="custom-control-label" for="customSwitch1">Want to change email</label>
                </div>
            </div>

            <div v-if="option">
                <input type="email" v-model="reciver_email" class="form-control" >
            </div>
            <div v-else>
                 <input type="email" v-model="reciver_email" class="form-control disabled" disabled>
            </div>
        </div>
        <div class="card-footer">
             <div v-if="option">
                <button class="btn btn-success btn-sm float-right" >Change</button>
            </div>
            <div v-else>
                 <button class="btn btn-success btn-sm float-right"  disabled>Change</button>
            </div>
        </div>
        </form>
    </div>
</template>
<script>
export default {
    data() {
        return {
            heading: "Reciver Email",
            option: false,
            reciver_email: '',
            message: '',
        }
    },
    methods: {
        getemail() {
            axios.get('/reciver-email')
                .then((resp) => {
                   this.reciver_email = resp.data;
                })
        },
        changeemail(e) {
            e.preventDefault();
            axios.post('/change-reciver-email', {
                email: this.reciver_email,
                csrf_token: $('meta[name="csrf-token"]').attr('content')
            }).then((resp) => {
                if(resp.data.response == true)
                {
                    this.option = false;
                    this.message = resp.data.message;
                }
            })
        }
    },
    created() {
  	   axios.get('/reciver-email')
                .then((resp) => {
                   this.reciver_email = resp.data;
                })
    },
}
</script>
