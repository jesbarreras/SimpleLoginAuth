<template>
  <v-container>
    
    <v-btn small color="primary" @click="showDialog = true">Insert</v-btn>

    <!-- Dialog for inserting data -->
    <v-dialog v-model="showDialog" max-width="500px">
      <v-card>
        <v-card-title>Add Data</v-card-title>
        <v-card-text>
          <v-form ref="form" class="insert-form">
            <v-text-field v-model="title" label="Title"></v-text-field>
            <v-textarea v-model="content" label="Content"></v-textarea>
            <v-date-picker v-model="date" label="Date" color = "primary"></v-date-picker>
          </v-form>
        </v-card-text>
        <v-card-actions>
          <v-btn color="blue darken-1" @click="insertData">Add</v-btn>
          <v-btn color="grey darken-1" @click="showDialog = false">Cancel</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-data-table :headers="headers" :items="items" :search="search" item-key="id" class="custom-table">
      <template v-slot:item.actions="{ item }">
        <v-btn v-if="!item.editable" @click="editRow(item)" small color="warning">Edit</v-btn>
        <v-btn @click="deleteRow(item)" small color="error">Delete</v-btn>
        <v-btn v-if="item.editable" @click="saveEdit(item)" small color="primary">Save</v-btn>
      </template>
      <template v-slot:item.title="{ item }">
        <span v-if="!item.editable">{{ item.title }}</span>
        <v-text-field v-else v-model="item.title"></v-text-field>
      </template>
      <template v-slot:item.content="{ item }">
        <span v-if="!item.editable">{{ item.content }}</span>
        <v-text-field v-else v-model="item.content"></v-text-field>
      </template>
      <template v-slot:item.date="{ item }">
        <span v-if="!item.editable">{{ item.date }}</span>
        <v-text-field v-else v-model="item.date"></v-text-field>
      </template>
    </v-data-table>
    
    
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      headers: [
        { text: 'ID', align: 'start', value: 'id' },
        { text: 'Title', value: 'title' },
        { text: 'Content', value: 'content' },
        { text: 'Date', value: 'date' },
        { text: 'Actions', value: 'actions', sortable: false }
      ],
      items: [],
      search: '',
      date:null,
      title: '',
      content:'',
      showDialog: false,
      dateWithoutTime: null
    }
  },
  methods: {
    fetchItems() {
      // API call to Laravel backend to fetch data
      axios.get('/api/getData')
        .then(response => {
          this.items = response.data.map(item => ({
            ...item,
            editable: false
          }));
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
    },
    
    async insertData() {
    try {
     //validate data before sending it
      if (!this.title || !this.content || !this.date) {
        throw new Error("Please fill in all fields");
      }
      
      this.dateWithoutTime = new Date(this.date).toISOString().split('T')[0];
      // API call to insertData
      const newData = {
        title: this.title,
        content: this.content,
        date: this.dateWithoutTime
      };
      
      //  API call success
      const response = await axios.post('/api/insertData', newData);
      console.log('Insert successful:', response.data);
      alert('Insert Data Successfully');
      
      // Optionally, refresh the table data
      this.fetchItems();
      
      // Close the dialog after successful insertion
      this.showDialog = false;
    } catch (error) {
      console.error('Error inserting data:', error.response.data);
      alert('Error inserting data: ' + error.message);
      console.log(this.title)
      console.log(this.content)
      console.log(this.date)
    }
  },
    
    editRow(item) {
      item.editable = true;
    },

    //update
    saveEdit(item) {
      // API call to update the row
      axios.put(`/api/update/${item.id}`, item)
        .then(response => {
          console.log('Update successful:', response.data);
          alert('Update Data Successfully')
          // Reset the editable flag after saving
          item.editable = false;
        })
        .catch(error => {
          console.error('Error updating row:', error);
        });
    },
    deleteRow(item) {
      // API call to delete the row
      axios.delete(`/api/delete/${item.id}`)
        .then(response => {
          console.log('Delete successful:', response.data);
          alert('Delete Successfully')
          // Remove the deleted item from the items array
          const index = this.items.findIndex(i => i.id === item.id);
          if (index !== -1) {
            this.items.splice(index, 1);
          }
        })
        .catch(error => {
          console.error('Error deleting row:', error);
        });
    },

  },
  mounted() {
    this.fetchItems();
  }
}
</script>

<style scoped>
.custom-table {
  border: 1px solid #ccc;
  border-collapse: collapse;
  width: 100%;
}

.custom-table th,
.custom-table td {
  border: 1px solid #ccc;
  padding: 8px;
  text-align: left;
}
</style>
