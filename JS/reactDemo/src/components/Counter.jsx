import React from 'react'
import { connect } from 'react-redux';
import { withAppContext } from '../js/AppContext'
import * as counterAction from '../redux/action/counterAction'
import $ from "jquery";
 
class Counter extends React.Component {
  constructor(props){
    super(props);
  }

  increment(){
    this.props.dispatch(counterAction.incrementState());
  }

  decrement(){
    //this.props.dispatch({ type: 'DECREMENT' });
    this.props.dispatch(counterAction.decrementState());
  }

  render() {
    return (
      <div>
        <div>
          <button onClick={()=>{this.decrement()}}>-</button>
          <span>{this.props.count}</span>
          <button onClick={()=>{this.increment()}}>+</button>
        </div>
      </div>
    )
  }
}

/**
 * 从peers中
 */
function mapStateToProps(state) {

  return {
     count:state.counter.count
  }
}

function mapDispatchToProps(dispatch) {
  return {};
}

export default connect(mapStateToProps)(Counter);
