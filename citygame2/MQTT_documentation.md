# Researching MQTT
MQTT abbreviation meaning = Message Queue Telemetry Transport.
MQTT -> We will use Mosquitto broker

MQTT is a protocol that can be used instead of http or other protocols. Here are some differences between MQTT and HTTP:

### MQTT:

+ MQTT is **data-centric**.
+ MQTT is a **reliable and light transport protocol** that permit IoT (Internet of Things) devices to communicate with other devices.
+ This protocol **uses really few bytes** to describe the content of the messages, so it can be very useful to adopt in a context where we need to exchange small messages and when we don’t have a great bandwidth (**uses lesser bandwidth**). **It transfers data as a byte array**.
+ MQTT is typically used for **communication between machine to machine**.
+ MQTT is a simple **pub-sub messaging system** (**publisher-subscriber**) which is loosely coupled, which allows client’s existence independent of any other device and is a **bidirectional communication channel**.
+ MQTT is **a more developer oriented protocol** with **less specification**, **methods** (Subscribe, Publish, Connect, Disconnect, Unsubscribe), and **message types**.
+ Header of a MQTT message has a **size of 2 bytes** and the **message itself is in binary format**.
+ MQTT **supports 3 QOS levels** out of the box in message publication, which makes developers life easy as there is no requirement to write complex, additional logic to ensure message delivery.
+ MQTT has a built-in distribution mechanism, supporting **one to one, one to many, one to zero distribution models**.

### HTTP:

+ HTTP is **document-centric**.
+ HTTP follows the **request/response messaging model**, where client’s need to know the exact address of the device to which it connects.
+ HTTP is a **complex protocol** and uses **methods** like **POST, PUT, GET, UPDATE,…** and many return codes.
+ HTTP is **text-oriented** and **consumes a lot of network bandwidth.** This might be a high concern for mobile apps users to some extent and such constraint device would not desire such sophisticated protocol as HTTP, **draining the battery** as we all are aware of (Uses a lot of battery).
+ HTTP does **not have any retry ability or QOS**.
+ HTTP is a **point-to-point communication**.

---

## MQTT methods:

+ **Connect**: Waits for a connection to be established with the server.
+ **Disconnect**: Waits for the MQTT to finish any work it must do, and for the TCP/IP session to disconnect.
+ **Subscribe**: Waits for completion of the subscribe or unsubscribe method.
+ **Unsubscribe**: : Requests the server unsubscribe the client from one or more topics.
+ **Publish**: Returns immediately to the application thread after passing the request to the MQTT client.

### Real-world application examples:

+ Facebook messenger
+ Amazon web services

---

## How does MQTT work?

Imagine that you have all kind of different machines and sensors connected to the internet. These machines and sensors are all independent. With MQTT the machines and sensors can communicate with each other.

![mqtt1](http://project.labict.be/attachments/download/1777/mqtt.png)

### An example:

When a Temperature sensor sends a message with the measured temperature (here 20°C) to the broker, then the broker will send the message with the measured temperature to every subscriber connected to the broker.

![mqtt2](http://project.labict.be/attachments/download/1778/mqtt2.png)

Only the devices that need the information that has been send by the temperature sensor will keep the information and use it. Devices that don’t need the information will get the receive the information but won’t use it.

![mqtt3](http://project.labict.be/attachments/download/1779/mqtt3.png)

So when the temperature sensor detects that the temperature decreases to 18°C, then this message will be sent to all subscribers. The airco knows now that the temperature has decreased, so it turns on and warms the room or building until it is back on 20°C.

![mqtt4](http://project.labict.be/attachments/download/1780/mqtt4.png)

When the temperature sensor detects that the temperature increases to 22°C, then this message will be sent to all subscribers. The airco knows now that the temperature has increased, so it turns on and cools the room or building until it is back on 20°C.

![mqtt5](http://project.labict.be/attachments/download/1781/mqtt5.png)

Because it is possible to make different kinds of combinations. I'll give another example:

When the car is closing in to his destination (here : home). Then it will send this information to the broker and the broker will send it to the coffee machine. So when you come home, there will be a fresh cup of coffee waiting for you.


![mqtt6](http://project.labict.be/attachments/download/1782/mqtt6.png)
