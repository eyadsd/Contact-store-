<template>
<div>
    
           
    <h3>Add new contact</h3>
    <form action="#" >
        <div class = "form-group">
            <label>First Name</label>
            <input v-model  = "contact.FirstName" name="name" class = "form-control" >
        </div>
        <div class = "form-group">
            <label>Last Name</label>
            <input v-model = "contact.LastName" name="name" class = "form-control" >
        </div>
        <div class = "form-group">
            <label>Phone Number</label>
            <input v-model = "contact.PhoneNumber" type="text" class = "form-control">

        </div>
        <div class = "form-group">
            <label>Mobile Number</label>
            <input v-model = "contact.MobileNumber" type="text" class = "form-control">

        </div>
        <div class = "form-group">
            <label>Email</label>
            <input v-model = "contact.Email" type="text" class = "form-control">

        </div>
        <div class = "form-group">
            <label>Birth Date</label>
            <input v-model = "contact.BirthDate" type="text" class = "form-control">

        </div>
        <div class = "form-group">
            <label>Address</label>
            <input v-model = "contact.Address" type="text" class = "form-control">

        </div>
        <div class="form-group">
            <button v-show= "!edit" type = "submit" class = "btn btn-primary" @click = "createContact">Add Contact</button>
            <button v-show= "edit" type = "submit" class = "btn btn-primary" @click = "updateContact(contact.id)">Update</button>
        </div>
        </form>
        <br><br>
        

            <div class = "row"  >
                <div class="col-sm-6" >
                <h3 class = "d-inline">Contacts</h3> <div class="d-inline float-right"><h5  class="text-muted d-inline">search</h5> <input  type="text" @keyup = "search" v-model= "searchText"> </div>
            <ul  class = "list-group" style = "overflow-y:scroll;max-height:500px;">
                <a  href = "#/" @click = "displayContact(contact.id)"  class = "list-group-item list-group-item-action"  v-for = "contact in filteredList" :key = "contact.id"> <b>{{contact.FirstName}} {{contact.LastName}} </b>
                <button class = "btn btn-default btn-xs float-right" @click = "showContact(contact.id)">edit</button>
                <button class = "btn btn-danger btn-xs float-right" @click = "deleteContact(contact.id)">delete</button>
                 </a>
            </ul>
            </div>
            

            <div class = "col-sm-6 " >
                <br>
                <ul  class="list-group">
                    <li class="list-group-item"><b>first name:</b> <br>{{selectedContact.FirstName}}</li>
                    <li class="list-group-item"><b>last name:</b><br>{{selectedContact.LastName}}</li>
                    <li class="list-group-item"><b>phone number</b><br>{{selectedContact.PhoneNumber}}</li>
                    <li class="list-group-item"><b>mobile number</b> <br>{{selectedContact.MobileNumber}}</li>
                    <li class="list-group-item"><b>email</b> <br>{{selectedContact.Email}}</li>
                    <li class="list-group-item"><b>birth date</b> <br>{{selectedContact.BirthDate}}</li>
                    <li class="list-group-item"><b>address</b> <br>{{selectedContact.Address}}</li>
                    
                    
                </ul>
                
            </div>
            </div>
    </div>
</template>

<script>
    export default{
        data: function(){
            return {
                edit:false,
                list:[],
                contact:{
                    id:'',
                    FirstName:'',
                    LastName:'',
                    Email:'',
                    PhoneNumber:'',
                    MobileNumber:'',
                    BirthDate:'',
                    Address : ''
                },
                selectedContact:{
                    id:'',
                    FirstName:'',
                    LastName:'',
                    Email:'',
                    PhoneNumber:'',
                    MobileNumber:'',
                    BirthDate:'',
                    Address : ''
                },
                searchText:''
            }
        },
        mounted: function(){
            console.log('contacts component loaded...');
            this.fetchContactList();
        },
        methods: {
            fetchContactList: function(){
                console.log('fetching contacts...');
                axios.get('api/contacts').then((response) => {
                    console.log(response.data);
                    this.list = response.data;
                }).catch(error =>{
                    console.log(error);
                });
            },
           displayContact(id){
            //    this.list.array.forEach(element => {
            //        if(element.id == id)
            //        {
            //            this.selectedContact = element;
            //        }
                   
            //    });
               let self = this;
                axios.get('api/contact/'+id)
                .then((response) => {
                    self.selectedContact.id = response.data.id;
                    self.selectedContact.FirstName = response.data.FirstName;
                    self.selectedContact.LastName = response.data.LastName;
                    self.selectedContact.Email = response.data.Email;
                    self.selectedContact.Address = response.data.Address;
                    self.selectedContact.BirthDate = response.data.BirthDate;
                    self.selectedContact.PhoneNumber = response.data.PhoneNumber;
                    self.selectedContact.MobileNumber = response.data.MobileNumber;

                })
           },
            showContact: function(id)
            {
                let self = this;
                axios.get('api/contact/'+id)
                .then((response) => {
                    self.contact.id = response.data.id;
                    self.contact.FirstName = response.data.FirstName;
                    self.contact.LastName = response.data.LastName;
                    self.contact.Email = response.data.Email;
                    self.contact.Address = response.data.Address;
                    self.contact.BirthDate = response.data.BirthDate;
                    self.contact.PhoneNumber = response.data.PhoneNumber;
                    self.contact.MobileNumber = response.data.MobileNumber;

                })
                self.edit = true;
                
            },

            createContact: function(){
                console.log('creating contact...');
                let self = this;
                //let params = object.assign({}, self.contact);
                let params = self.contact;
                axios.post('api/contact/store',params)
                .then(function(){
                    self.contact.FirstName = '';
                    self.contact.LastName = '';
                    self.contact.Email = '';
                    self.contact.PhoneNumber = '';
                    self.contact.MobileNumber = '';
                    self.contact.BirthDate = '';
                    self.contact.Address = '';
                    self.edit = false;
                    self.fetchContactList();
                   
                }).catch(function(error){
                    console.log(error);
                });
            },
            updateContact: function(id){
                let self = this;
                //let params = object.assign({}, self.contact);
                let params = self.contact;
                axios.patch('api/contact/'+id,params)
                .then(function(){
                    self.contact.FirstName = '';
                    self.contact.LastName = '';
                    self.contact.Email = '';
                    self.contact.PhoneNumber = '';
                    self.contact.MobileNumber = '';
                    self.contact.BirthDate = '';
                    self.contact.Address = '';
                    self.edit = false;
                    self.fetchContactList();
            }).catch((error)=>{
                console.log(error);
            });
            },
            deleteContact(id){
                axios.delete('api/contact/'+id)
                .then((response) => {
                    this.fetchContactList();
                }).catch((error) =>{
                    console.log(error);
                });

            },
            search(){
               
            }
        },
        computed:{
            filteredList(){
                return this.list.filter((element)=>{
                    return element.FirstName.toLowerCase().match(this.searchText.toLowerCase())||
                    element.LastName.toLowerCase().match(this.searchText.toLowerCase())||
                   ( element.FirstName.toLowerCase() + ' ' + element.LastName.toLowerCase()).match(this.searchText.toLowerCase()) ;
                })
            }
        }
        
    }
    
</script>