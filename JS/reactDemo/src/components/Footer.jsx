import React from 'react'
class Footer extends React.Component {
  constructor(props) {
    super(props);
    this.state = {name: '小花',sex:'女',age:18}
  }
  changeAll(){
    this.setState({
      name: "老王",
      sex: '男',
      age: 30
    });
  }

  changeName(){
    this.setState({
      name: "老李",
    });
  }

  render() {
    return (
      <div>
        <h2>姓名：{this.state.name}</h2>
        <h2>性别：{this.state.sex}</h2>
        <h2>年龄：{this.state.age}</h2>
        <h2>参数: {this.props.title}</h2>
        <p>hello wold!</p>
        <button onClick={()=>{this.changeAll()}}>change </button>
        <button onClick={()=>{this.changeName()}}>change name</button>
      </div>
    )
  }
}

export default Footer;