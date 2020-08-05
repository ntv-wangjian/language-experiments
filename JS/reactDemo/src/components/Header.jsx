import React from 'react'
import { connect } from 'react-redux';
import { withAppContext } from '../js/AppContext'
import * as userAction from '../redux/action/userAction'
import $ from "jquery";
 
class Header extends React.Component {
  constructor(props){
    super(props);
    this.num = 0;
  }

  changeName(){
    let name = "小明" + this.num++;
    let user = {name:name,img:""};
    this.props.dispatch(userAction.userState(user));
  }

  render() {
    return (
      <div>
        <h2>{this.props.user.name}</h2>
        <button onClick={()=>{this.changeName()}}>change</button>
      </div>
    )
  }
}

/**
 * 从peers中
 */
function mapStateToProps(state) {
  
  return {
     user:state.user.user
  }
}

function mapDispatchToProps(dispatch) {
  return {};
}

export default connect(mapStateToProps)(Header);
