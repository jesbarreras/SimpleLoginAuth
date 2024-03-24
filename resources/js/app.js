
require('./bootstrap')

import { createApp } from 'vue'
import routes from './route.js'
import { createVuetify } from 'vuetify'
import 'vuetify/styles'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import { aliases, mdi } from 'vuetify/iconsets/mdi'



const app = createApp({})

const vuetify = createVuetify({
    components,
    directives,
  })


export default createVuetify({
   
    icons: {
      defaultSet: 'mdi',
      aliases,
      sets: {
        mdi,
      }
    },
  components, // Include all components
  directives, // Include all directives
    
  })

app.use(vuetify)
app.use(routes)
app.mount('#app')
