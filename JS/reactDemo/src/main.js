import React from 'react'
import { render } from 'react-dom';
import { Provider } from 'react-redux'
import { createStore } from 'redux'
import reducers from './redux/reducter'
import Counter from './Components/Counter.jsx'
import Header from './Components/Header.jsx'
import Footer from './Components/Footer.jsx'

import $ from "jquery";

const store = createStore(reducers);
const App = () => (
        <Provider store={store}>
          <h1>React</h1>
          <Header />
          <br/><br/>
          <Counter />
          <br/><br/>
          <Footer title="标题" name="老王" />
        </Provider>
      );
      render(<App />, document.getElementById('root'));