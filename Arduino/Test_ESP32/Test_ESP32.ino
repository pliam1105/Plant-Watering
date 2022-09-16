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
const int pin_8 = 0;
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
const char* ssid     = "PliamCom";
const char* password = "p@$$w0rd";

//server credentials
const char* serverName = "http://plmoiver.rovergr.space/post_moisture_esp.php";

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
  // put your setup code here, to run once:
  Serial.begin(115200);
  Serial.println("Woke Up!");
  reset_sensors();
  read_sensors();
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

void loop() {



}

void read_sensors () {

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
