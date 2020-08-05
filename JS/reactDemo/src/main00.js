import React from 'react'
import ReactDOM from 'react-dom'
import { Provider } from 'react-redux'
import { createStore } from 'redux'
import reducers from './redux/reducter'
import AppContext from './js/AppContext'
import * as utils from './js/utils'
import Counter from './Components/Counter.jsx'
import $ from "jquery";

const store            = createStore(reducers);
ReactDOM.render(
    <Provider store={store}>
            <Counter />
    </Provider>, 
    document.getElementById('root'))
