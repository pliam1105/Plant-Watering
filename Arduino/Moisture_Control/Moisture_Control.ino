#include <WiFi.h>
#include <HTTPClient.h>
#include <NTPClient.h>
#include <WiFiUdp.h>

//sensor pins
const int pin_1 = 36;//ADC1
const int pin_2 = 39;
const int pin_3 = 32;
const int pin_4 = 33;
const int pin_5 = 34;
const int pin_6 = 35;

const int pin_7 = 4;//ADC2
const int pin_8 = 26;
const int pin_9 = 2;
const int pin_10 = 15;
const int pin_11 = 13;
const int pin_12 = 12;
const int pin_13 = 14;
const int pin_14 = 27;
const int pin_15 = 25;

//sensor values
int val_1 = 0;
int val_2 = 0;
int val_3 = 0;
int val_4 = 0;
int val_5 = 0;
int val_6 = 0;
int val_7 = 0;
int val_8 = 0;
int val_9 = 0;
int val_10 = 0;
int val_11 = 0;
int val_12 = 0;
int val_13 = 0;
int val_14 = 0;
int val_15 = 0;

//value range
const int dry = 3700;
const int wet = 1900;

//php auth code
String api_key = "tk647vDfs2Kes";

//network credentials
const char* ssid     = "WIFI0";
const char* password = "p@$$w0rd";

//server credentials
const char* serverName = "http://pliamprojects.000webhostapp.com/plants/post_moisture_esp.php";

//sleep variables
uint64_t sleep_hours = 2;
uint64_t big_sleep = 14;
uint64_t hours_m_seconds = 3600000000;

// Variables to save date and time
String formattedDate;
String dayStamp;
String timeStamp;
int time_val;

void setup() {
  Serial.begin(115200);
  Serial.println("Woke Up!");
  read_sensors();
  WiFi.begin(ssid, password);
  Serial.println("Connecting");
  while(WiFi.status() != WL_CONNECTED) { 
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());
  
  get_time();
}

void reset_sensors() {
  //because on first measure values are not correct, but on the second are correct(on some pins of ADC2)
  map(analogRead(pin_1), dry, wet, 0, 100);
  delay(50);
  map(analogRead(pin_2), dry, wet, 0, 100);
  delay(50);
  map(analogRead(pin_3), dry, wet, 0, 100);
  delay(50);
  map(analogRead(pin_4), dry, wet, 0, 100);
  delay(50);
  map(analogRead(pin_5), dry, wet, 0, 100);
  delay(50);
  map(analogRead(pin_6), dry, wet, 0, 100);
  delay(50);
  map(analogRead(pin_7), dry, wet, 0, 100);
  delay(50);
  map(analogRead(pin_8), dry, wet, 0, 100);
  delay(50);
  map(analogRead(pin_9), dry, wet, 0, 100);
  delay(50);
  map(analogRead(pin_10), dry, wet, 0, 100);
  delay(50);
  map(analogRead(pin_11), dry, wet, 0, 100);
  delay(50);
  map(analogRead(pin_12), dry, wet, 0, 100);
  delay(50);
  map(analogRead(pin_13), dry, wet, 0, 100);
  delay(50);
  map(analogRead(pin_14), dry, wet, 0, 100);
  delay(50);
  map(analogRead(pin_15), dry, wet, 0, 100);

  delay(500);
}

void get_time(){
  
  // Define NTP Client to get time
  WiFiUDP ntpUDP;
  NTPClient timeClient(ntpUDP);

  // Initialize a NTPClient to get time
  timeClient.begin();
  // Set offset time in seconds to adjust for your timezone, for example:
  // GMT +1 = 3600
  // GMT +8 = 28800
  // GMT -1 = -3600
  // GMT 0 = 0
  timeClient.setTimeOffset(3*3600);
  
  while(!timeClient.update()) {
    timeClient.forceUpdate();
  }
  // The formattedDate comes with the following format:
  // 2018-05-28T16:00:13Z
  // We need to extract date and time
  formattedDate = timeClient.getFormattedDate();
  Serial.println(formattedDate);

  // Extract date
  int splitT = formattedDate.indexOf("T");
  dayStamp = formattedDate.substring(0, splitT);
  Serial.print("DATE: ");
  Serial.println(dayStamp);
  // Extract time
  timeStamp = formattedDate.substring(splitT+1, formattedDate.length()-1);
  Serial.print("HOUR: ");
  Serial.println(timeStamp);

  int splitTime = timeStamp.indexOf(":");
  time_val = timeStamp.substring(0,splitTime).toInt(); // get time as int
  
  delay(500);
}

void loop() {

  //Check WiFi connection status
  if(WiFi.status()== WL_CONNECTED){
    HTTPClient http;
    
    // Specify content-type header
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    
    // Prepare your HTTP POST request data
    String httpRequestData = "api_key=" + api_key + "&sensor1=" + val_1
    + "&sensor2=" + val_2
    + "&sensor3=" + val_3
    + "&sensor4=" + val_4
    + "&sensor5=" + val_5
    + "&sensor6=" + val_6
    + "&sensor7=" + val_7
    + "&sensor8=" + val_8
    + "&sensor9=" + val_9
    + "&sensor10=" + val_10
    + "&sensor11=" + val_11
    + "&sensor12=" + val_12
    + "&sensor13=" + val_13
    + "&sensor14=" + val_14
    + "&sensor15=" + val_15 + "";
    Serial.print("httpRequestData: ");
    Serial.println(httpRequestData);

    String url = serverName + String("?") + httpRequestData;
    Serial.print("Request URL: ");
    Serial.println(url);
    
    // Send HTTP GET request
    http.begin(url);
    int httpResponseCode = http.GET();
    String response = "";
    if (httpResponseCode>0) {
      response = http.getString();
      
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);
      Serial.print("Response: ");
      Serial.println(response);
    }
    else {
      Serial.print("Error code: ");
      Serial.println(httpResponseCode);
    }
    
    // Free resources
    http.end();

    //check response and sleep
    if(httpResponseCode == 200 && response == "New record created successfully"){
      //success
      uint64_t sleep_time = sleep_hours;
      if(time_val > 6 && time_val < 20){
        //big sleep
        big_sleep = 20 - time_val; // calculate sleep time
        sleep_time = big_sleep;
      }
      Serial.println("Going to sleep for " + String(uint64_to_string(sleep_time)) + " hours!");
      //Deep sleep
      esp_sleep_enable_timer_wakeup(sleep_time * hours_m_seconds);
      esp_deep_sleep_start();
    }
  }
  else {
    Serial.println("WiFi Disconnected");
  }
  //Check connection every 30 seconds
  delay(30000);  
  
}

void read_sensors (){

  reset_sensors();//to use adc2 pins

  val_1 = map(analogRead(pin_1), dry, wet, 0, 100);
  Serial.println("Sensor 1: " + String(val_1) + " %");
  delay(50);
  val_2 = map(analogRead(pin_2), dry, wet, 0, 100);
  Serial.println("Sensor 2: " + String(val_2) + " %");
  delay(50);
  val_3 = map(analogRead(pin_3), dry, wet, 0, 100);
  Serial.println("Sensor 3: " + String(val_3) + " %");
  delay(50);
  val_4 = map(analogRead(pin_4), dry, wet, 0, 100);
  Serial.println("Sensor 4: " + String(val_4) + " %");
  delay(50);
  val_5 = map(analogRead(pin_5), dry, wet, 0, 100);
  Serial.println("Sensor 5: " + String(val_5) + " %");
  delay(50);
  val_6 = map(analogRead(pin_6), dry, wet, 0, 100);
  Serial.println("Sensor 6: " + String(val_6) + " %");
  delay(50);
  val_7 = map(analogRead(pin_7), dry, wet, 0, 100);
  Serial.println("Sensor 7: " + String(val_7) + " %");
  delay(50);
  val_8 = map(analogRead(pin_8), dry, wet, 0, 100);
  Serial.println("Sensor 8: " + String(val_8) + " %");
  delay(50);
  val_9 = map(analogRead(pin_9), dry, wet, 0, 100);
  Serial.println("Sensor 9: " + String(val_9) + " %");
  delay(50);
  val_10 = map(analogRead(pin_10), dry, wet, 0, 100);
  Serial.println("Sensor 10: " + String(val_10) + " %");
  delay(50);
  val_11 = map(analogRead(pin_11), dry, wet, 0, 100);
  Serial.println("Sensor 11: " + String(val_11) + " %");
  delay(50);
  val_12 = map(analogRead(pin_12), dry, wet, 0, 100);
  Serial.println("Sensor 12: " + String(val_12) + " %");
  delay(50);
  val_13 = map(analogRead(pin_13), dry, wet, 0, 100);
  Serial.println("Sensor 13: " + String(val_13) + " %");
  delay(50);
  val_14 = map(analogRead(pin_14), dry, wet, 0, 100);
  Serial.println("Sensor 14: " + String(val_14) + " %");
  delay(50);
  val_15 = map(analogRead(pin_15), dry, wet, 0, 100);
  Serial.println("Sensor 15: " + String(val_15) + " %");
  
  delay(500);
}

char *uint64_to_string(uint64_t input)
{
    static char result[21] = "";
    // Clear result from any leftover digits from previous function call.
    memset(&result[0], 0, sizeof(result));
    // temp is used as a temporary result storage to prevent sprintf bugs.
    char temp[21] = "";
    char c;
    uint8_t base = 10;

    while (input) 
    {
        int num = input % base;
        input /= base;
        c = '0' + num;

        sprintf(temp, "%c%s", c, result);
        strcpy(result, temp);
    } 
    return result;
}
