import React from 'react';

const AppContext = React.createContext();

export default AppContext;

export function withAppContext(Component)
{
	return (props) => ( // eslint-disable-line react/display-name
		<AppContext.Consumer>
			{(contextParas) => <Component {...props} {...contextParas} />}
		</AppContext.Consumer>
	);
}
