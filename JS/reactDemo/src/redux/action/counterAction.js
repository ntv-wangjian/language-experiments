/**
 * 获取了会议纪要
 */
export const incrementState = state => ({
    type: 'INCREMENT',
    payload:state
})

/**
 * 提交了会议纪要
 */
export const decrementState = state => ({
    type: 'DECREMENT',
    payload:state
})
