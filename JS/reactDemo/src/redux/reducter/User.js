const initialUser = {
    user: {name:"小明",img:""}
  };
const user = (state = initialUser, action) => {
    switch (action.type) {
        case 'USER_INFO':{
            const user  = action.payload;
			return { ...state, user: user };
        }

        default:
        return state
    }
}

export default user