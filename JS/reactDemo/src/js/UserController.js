import * as noteAction from '../redux/action/noteAction'

/**
 * 总控制类： 
 *  1）调用业务接口，根据接口返回更新状态 
 *  2）更新状态，发送状态消息给view
 */
export default class UserController{
    constructor(store)
	{
        this.store  = store;
    }
}