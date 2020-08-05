import { combineReducers } from 'redux'
import user from './User'
import counter from './Counter'

const reducers = combineReducers(
{
	user,
	counter,
});

export default reducers;