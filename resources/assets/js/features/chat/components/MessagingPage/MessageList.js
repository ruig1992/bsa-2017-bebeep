import React from 'react';
import {bindActionCreators} from 'redux';
import {connect} from 'react-redux';
import moment from 'moment';
import {getTranslate} from 'react-localize-redux';
import {deleteMessage} from '../../actions';
import Message from './Message';
import ChatService from 'features/chat/services/ChatService';

class MessageList extends React.Component {
    moveToBottom() {
        this.chatContainer.scrollTop = this.chatContainer.scrollHeight;
    }
    componentDidMount() {
        this.moveToBottom();
    }

    componentDidUpdate() {
        this.moveToBottom();
    }

    onDeleteMessage(id) {
        const {userId, deleteMessage} = this.props,
            data = {id, userId};

        ChatService.deleteMessage(id)
            .then(response => {
                if(response.status === 200) {
                    deleteMessage(data);
                }
            });
    }

    render() {
        const {translate, messages, user} = this.props;

        return (
            <ul className="chat" key={moment()} ref={(container) => this.chatContainer = container}>
                {messages.map((message, i) => {
                    return (
                        <Message
                            key={i}
                            keyId={i}
                            messageData={message}
                            userData={user}
                            onDeleteMessage={ () => this.onDeleteMessage(message.id) }
                        />
                    );
                })}
            </ul>
        );
    }
}

export default connect(
    state => ({
        translate: getTranslate(state.locale)
    }),
    dispatch => (bindActionCreators({deleteMessage}, dispatch))
)(MessageList);
