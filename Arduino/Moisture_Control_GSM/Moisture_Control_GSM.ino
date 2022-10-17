// Configure TinyGSM library
#define TINY_GSM_MODEM_SIM800
//#define TINY_GSM_RX_BUFFER   1024
#include <TinyGsmClient.h>

// Set serial for debug console (to Serial Monitor, default speed 115200)
#define SerialMon Serial

HardwareSerial SerialAT(1);
TinyGsm modem(SerialAT);
TinyGsmClient client(modem);
const int BAUD_RATE = 9600;
const int RX_PIN = 16, TX_PIN = 17;

// Your GPRS credentials (leave empty, if not needed)
const char apn[]      = "internet"; // APN (example: internet.vodafone.pt) use https://wiki.apnchanger.org
const char gprsUser[] = ""; // GPRS User
const char gprsPass[] = ""; // GPRS Password

// SIM card PIN (leave empty, if not defined)
const char simPIN[]   = ""; 

// Server details
const char server[] = "pliamprojects.000webhostapp.com";
const char resource[] = "/plants/post_moisture_esp.php";
const int  port = 80;

const int pin_transistor = 5;

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
const int dry = 4095;
const int wet = 2600;

//php auth code
String api_key = "tk647vDfs2Kes";

//sleep variables
unsigned long long big_sleep = 12;
unsigned long long hours_m_seconds = 3600000000;

void setup() {
  pinMode(pin_transistor,OUTPUT);
  digitalWrite(pin_transistor,HIGH);
  Serial.begin(115200);
  Serial.println("Woke Up!");
  read_sensors();
  //initialize SIM800L
  // Unlock your SIM card with a PIN if needed
  if (strlen(simPIN) && modem.getSimStatus() != 3 ) {
    modem.simUnlock(simPIN);
  }
  SerialAT.begin(BAUD_RATE, SERIAL_8N1, RX_PIN, TX_PIN, false);
  delay(3000);
  SerialMon.println("Initializing modem...");
  modem.restart();
}

void loop() {
  digitalWrite(pin_transistor,LOW);
  delay(3000);
  digitalWrite(pin_transistor,HIGH);
  SerialMon.print("Connecting to APN: ");
  SerialMon.print(apn);
  if (!modem.gprsConnect(apn, gprsUser, gprsPass)) {
    SerialMon.println(" fail");
  }
  else {
    SerialMon.println(" OK");
    
    SerialMon.print("Connecting to ");
    SerialMon.print(server);
    if (!client.connect(server, port)) {
      SerialMon.println(" fail");
    }
    else {
      SerialMon.println(" OK");
    
      // Making an HTTP POST request
      SerialMon.println("Performing HTTP POST request...");
      // Prepare HTTP POST request data
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
    
      client.print(String("POST ") + resource + " HTTP/1.1\r\n");
      client.print(String("Host: ") + server + "\r\n");
      client.println("Connection: close");
      client.println("Content-Type: application/x-www-form-urlencoded");
      client.print("Content-Length: ");
      client.println(httpRequestData.length());
      client.println();
      client.println(httpRequestData);

      unsigned long timeout = millis();
      while (client.connected() && millis() - timeout < 10000L) {
        // Print available data (HTTP response from server)
        while (client.available()) {
          char c = client.read();
          SerialMon.print(c);
          timeout = millis();
        }
      }
      SerialMon.println();
    
      // Close client and disconnect
      client.stop();
      SerialMon.println(F("Server disconnected"));
      modem.gprsDisconnect();
      SerialMon.println(F("GPRS disconnected"));
      if(true){//check response and sleep
        uint64_t sleep_time = big_sleep;
        Serial.println("Going to sleep for " + String(uint64_to_string(sleep_time)) + " hours!");
        //Deep sleep
        digitalWrite(pin_transistor,LOW);
        gpio_deep_sleep_hold_en();
        gpio_hold_en(GPIO_NUM_5);
        esp_sleep_enable_timer_wakeup(sleep_time * hours_m_seconds);
        esp_deep_sleep_start();
        gpio_hold_dis(GPIO_NUM_5);
      }

    }
  }
  //Check connection every 30 seconds
  delay(30000);
}

void read_sensors (){

  measure_values();
  val_1 = map(val_1, dry, wet, 0, 100);
  Serial.println("Sensor 1: " + String(val_1) + " %");
  val_2 = map(val_2, dry, wet, 0, 100);
  Serial.println("Sensor 2: " + String(val_2) + " %");
  val_3 = map(val_3, dry, wet, 0, 100);
  Serial.println("Sensor 3: " + String(val_3) + " %");
  val_4 = map(val_4, dry, wet, 0, 100);
  Serial.println("Sensor 4: " + String(val_4) + " %");
  val_5 = map(val_5, dry, wet, 0, 100);
  Serial.println("Sensor 5: " + String(val_5) + " %");
  val_6 = map(val_6, dry, wet, 0, 100);
  Serial.println("Sensor 6: " + String(val_6) + " %");
  val_7 = map(val_7, dry, wet, 0, 100);
  Serial.println("Sensor 7: " + String(val_7) + " %");
  val_8 = map(val_8, dry, wet, 0, 100);
  Serial.println("Sensor 8: " + String(val_8) + " %");
  val_9 = map(val_9, dry, wet, 0, 100);
  Serial.println("Sensor 9: " + String(val_9) + " %");
  val_10 = map(val_10, dry, wet, 0, 100);
  Serial.println("Sensor 10: " + String(val_10) + " %");
  val_11 = map(val_11, dry, wet, 0, 100);
  Serial.println("Sensor 11: " + String(val_11) + " %");
  val_12 = map(val_12, dry, wet, 0, 100);
  Serial.println("Sensor 12: " + String(val_12) + " %");
  val_13 = map(val_13, dry, wet, 0, 100);
  Serial.println("Sensor 13: " + String(val_13) + " %");
  val_14 = map(val_14, dry, wet, 0, 100);
  Serial.println("Sensor 14: " + String(val_14) + " %");
  val_15 = map(val_15, dry, wet, 0, 100);
  Serial.println("Sensor 15: " + String(val_15) + " %");
}

void measure_values(){
  val_1=val_2=val_3=val_4=val_5=val_6=val_7=val_8=val_9=val_10=val_11=val_12=val_13=val_14=val_15=0;
  const int num = 500;
  for(int i=0;i<num;i++){
    val_1+=analogRead(pin_1);
    val_2+=analogRead(pin_2);
    val_3+=analogRead(pin_3);
    val_4+=analogRead(pin_4);
    val_5+=analogRead(pin_5);
    val_6+=analogRead(pin_6);
    val_7+=analogRead(pin_7);
    val_8+=analogRead(pin_8);
    val_9+=analogRead(pin_9);
    val_10+=analogRead(pin_10);
    val_11+=analogRead(pin_11);
    val_12+=analogRead(pin_12);
    val_13+=analogRead(pin_13);
    val_14+=analogRead(pin_14);
    val_15+=analogRead(pin_15);
    delay(20);
  }
  val_1/=num;
  val_2/=num;
  val_3/=num;
  val_4/=num;
  val_5/=num;
  val_6/=num;
  val_7/=num;
  val_8/=num;
  val_9/=num;
  val_10/=num;
  val_11/=num;
  val_12/=num;
  val_13/=num;
  val_14/=num;
  val_15/=num;
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
