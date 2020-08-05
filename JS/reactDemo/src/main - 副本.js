import React from 'react'
import ReactDOM from 'react-dom'
import { Provider } from 'react-redux'
import { createStore } from 'redux'
import reducers from './redux/reducter'
import AppContext from './js/AppContext'
import * as utils from './js/utils'
import Counter from './Components/Counter.jsx'
import $ from "jquery";

const user             = {name:"小明",img:""};
const store            = createStore(reducers);
const urlPara          = utils.urlPara();
const comParas         = {urlPara,user};
ReactDOM.render(
    <Provider store={store}>
        <AppContext.Provider value={comParas}>
            <Counter />
        </AppContext.Provider>
    </Provider>, 
    document.getElementById('root'))
