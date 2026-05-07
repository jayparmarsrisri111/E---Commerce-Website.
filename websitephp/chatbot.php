<!-- Link to separate CSS files -->
<link rel="stylesheet" href="css/chatbot.css">
<link rel="stylesheet" href="css/user-profile.css">

<div id="chatbot-container">
    <button id="chatbot-button" onclick="toggleChatbot()">
        <!-- AWS style often uses a simple chat bubble icon or an AI spark -->
        <i class="fas fa-comment"></i>
    </button>
    
    <div id="chatbot-window">
        <!-- Header -->
        <div id="chatbot-header">
            <div class="header-top">
                <span class="title">Ask MARINE TRADERS <span class="badge">built-in</span></span>
                <button id="chatbot-close" onclick="toggleChatbot()"><i class="fas fa-minus"></i></button>
            </div>
            <p class="header-subtitle">Get helpful guidance and recommendations from MARINE TRADERS generative AI assistant.</p>
            
            <div class="header-input-container" id="header-input-area">
                <input type="text" id="chatbot-input-header" placeholder="Ask a question" onkeypress="handleHeaderKeyPress(event)">
                <button onclick="sendFromHeader()"><i class="fas fa-arrow-right"></i></button>
            </div>
        </div>
        
        <div id="chatbot-body">
            <!-- Initial Suggestions View -->
            <div id="initial-suggestions">
                <p class="suggestions-title">Want help getting started?</p>
                <p class="suggestions-subtitle">Tell us a little bit about what you're looking for.</p>
                
                <button class="suggestion-pill" onclick="sendSuggestion('Connect with Sales Representative')">
                    Connect with Sales Representative
                </button>
                <button class="suggestion-pill" onclick="sendSuggestion('I want to learn about products and services')">
                    I want to learn about products and services
                </button>
                <button class="suggestion-pill" onclick="sendSuggestion('I need technical support')">
                    I need technical support
                </button>
                <button class="suggestion-pill" onclick="sendSuggestion('I have an account and billing issue')">
                    I have an account and billing issue
                </button>
                
                <div class="disclaimer">
                    By chatting, you agree to our <a href="#">terms and conditions</a>.
                </div>
            </div>
            
            <!-- Chat Messages View (Hidden Initially) -->
            <div id="chatbot-messages" style="display: none;">
                <!-- Messages will appear here -->
            </div>
            
            <div class="typing-indicator" id="chatbot-typing-indicator">
                AI is typing
                <div class="typing-dots">
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                </div>
            </div>
        </div>
        
        <!-- Bottom Input Area (Hidden Initially) -->
        <div id="chatbot-input-area">
            <input type="text" id="chatbot-input-bottom" placeholder="Ask a question..." onkeypress="handleBottomKeyPress(event)">
            <button id="chatbot-send-bottom" onclick="sendFromBottom()"><i class="fas fa-paper-plane"></i></button>
        </div>
        
    </div>
</div>

<script>
// Groq API Configuration
// NOTE: Replace with your own Groq API key from https://console.groq.com/keys
const GROQ_API_KEY = "YOUR_GROQ_API_KEY_HERE";
const GROQ_API_URL = "https://api.groq.com/openai/v1/chat/completions";

let chatHistory = [];
let isChatActive = false;

function toggleChatbot() {
    const window = document.getElementById("chatbot-window");
    if (window.style.display === "none" || window.style.display === "") {
        window.style.display = "flex";
    } else {
        window.style.display = "none";
    }
}

// Switch to chat view when user sends first message
function activateChatView() {
    if (!isChatActive) {
        document.getElementById("initial-suggestions").style.display = "none";
        document.getElementById("header-input-area").style.display = "none";
        
        document.getElementById("chatbot-messages").style.display = "flex";
        document.getElementById("chatbot-input-area").style.display = "flex";
        isChatActive = true;
    }
}

function handleHeaderKeyPress(event) {
    if (event.key === "Enter") sendFromHeader();
}

function handleBottomKeyPress(event) {
    if (event.key === "Enter") sendFromBottom();
}

function sendFromHeader() {
    const input = document.getElementById("chatbot-input-header");
    const msg = input.value.trim();
    if (msg) {
        activateChatView();
        sendMessage(msg);
        input.value = "";
    }
}

function sendFromBottom() {
    const input = document.getElementById("chatbot-input-bottom");
    const msg = input.value.trim();
    if (msg) {
        sendMessage(msg);
        input.value = "";
    }
}

function sendSuggestion(text) {
    activateChatView();
    sendMessage(text);
}

function appendMessage(sender, text) {
    const messagesDiv = document.getElementById("chatbot-messages");
    const msgDiv = document.createElement("div");
    msgDiv.className = "chatbot-message " + sender;
    
    // Format text
    let formattedText = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
    formattedText = formattedText.replace(/\n/g, '<br>');
    msgDiv.innerHTML = formattedText;
    
    messagesDiv.appendChild(msgDiv);
    
    // Scroll to bottom properly
    const bodyDiv = document.getElementById("chatbot-body");
    setTimeout(() => {
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }, 10);
}

async function sendMessage(message) {
    if (!message) return;

    appendMessage("user", message);
    
    const typingIndicator = document.getElementById("chatbot-typing-indicator");
    typingIndicator.style.display = "flex";
    document.getElementById("chatbot-messages").scrollTop = document.getElementById("chatbot-messages").scrollHeight;
    
    chatHistory.push({
        role: "user",
        content: message
    });
    
    try {
        // Construct messages for Groq (OpenAI format)
        const groqMessages = [
            { 
                role: "system", 
                content: "You are a helpful AI assistant for MARINE TRADERS, a ship equipment & trading company. Answer accurately, concisely, and cleanly based on business practices." 
            },
            ...chatHistory.map(msg => ({
                role: msg.role === 'assistant' ? 'assistant' : 'user',
                content: msg.content
            }))
        ];

        const response = await fetch(GROQ_API_URL, {
            method: "POST",
            headers: { 
                "Content-Type": "application/json",
                "Authorization": `Bearer ${GROQ_API_KEY}`
            },
            body: JSON.stringify({
                model: "llama-3.3-70b-versatile",
                messages: groqMessages
            })
        });
        
        const data = await response.json();
        typingIndicator.style.display = "none";
        
        if (response.ok && data.choices && data.choices.length > 0) {
            const botMessage = data.choices[0].message.content;
            appendMessage("bot", botMessage);
            
            chatHistory.push({
                role: "assistant",
                content: botMessage
            });
        } else {
            console.error("Groq API Error Response:", data);
            appendMessage("bot", "Sorry, I encountered an error answering your request. Please try again later. (Error: " + (data.error?.message || "Unknown API Error") + ")");
            chatHistory.pop();
        }
    } catch (error) {
        typingIndicator.style.display = "none";
        appendMessage("bot", "Error connecting to AI server. Please check your connection.");
        console.error("Chatbot Exception:", error);
        chatHistory.pop();
    }
}
</script>
