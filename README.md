Phalcon Preserve Post
---

Preserve **Form Data** after a **POST and Redirect**. We are using the standard [Phalcon Framework](http://phalconphp.com). 

---


**Setup**
- The setup requires **2** simple steps, or optionally **3**.
- Look at the `Example.php` file, you have to modify your Public Bootstrap, and add an Event Listener for the Dispatcher. 
- Optionally you can add a custom function for fetching the data, which I personally keep in a separate `functions.php` file.


**Notes**
- This uses plain `$_SESSION` data
- `$_SESSION` data is **reset** once viewed
- Your **Session must be started** before-hand (Phalcon Session)

**Why**
- I did not want to use the Form libraries for forms
- I want to use the flash Messages container because It's not automatic. (I don't think)

**Help**
- If you find a better way to do this let me know!

----
From [JREAM](http://jream.com)
